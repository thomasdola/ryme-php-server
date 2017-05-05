<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 6:47 PM
 */

namespace App\Http\Controllers\AppApi;


use Dingo\Api\Http\Request;
use Eureka\Helpers\Transformers\Mobile\ArtistRequestTransformer;
use Eureka\Helpers\Transformers\Mobile\MobileArtistItemTransformer;
use Eureka\Repositories\ArtistRepository;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use TomLingham\Searchy\Facades\Searchy;

class SearchController extends PublicApiController
{
    /**
     * @var ArtistRepository
     */
    private $artistRepository;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param ArtistRepository $artistRepository
     * @param Manager $fractal
     */
    public function __construct(ArtistRepository $artistRepository, Manager $fractal){
        $this->artistRepository = $artistRepository;
        $this->fractal = $fractal;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        if(!$request->has('q')){
            return $this->respondForSearch("error", 400, "Missing Arguments");
        }
        $artist_result = collect([]);
        $request_result = collect([]);
        $query = $request->get('q');
        $result = $this->artistRepository->search($query);
        collect($result->all())->each(function($request) use($artist_result, $request_result){
            if($request->is_artist == true){
                $artist_result->push($request);
            }
            $request_result->push($request);
        });
//        collect($this->auth->user()->vouchResponses->all())->each(function($rp){
//            echo $rp->id;
//        });
//        echo "----------------------";
//        $request_result->each(function($rq){
//           collect($rq->vouchRequests->all())->each(function($r){
//               echo $r->id;
//           });
//        });
        $result_q = $this->fractal->createData(new Collection($request_result->flatten()->all(),
            new ArtistRequestTransformer($this->auth->user())))
            ->toArray();
        $result_a = $this->fractal->createData(new Collection($artist_result->flatten()->all(),
            new MobileArtistItemTransformer()))->toArray();
        return $this->respondForSearch("success", 200, "success", $result_q, $result_a);
    }
}