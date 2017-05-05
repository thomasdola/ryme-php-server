<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 6:41 PM
 */

namespace App\Http\Controllers\AppApi;


use App\Jobs\FollowGenre;
use App\Jobs\followManyGenres;
use App\Jobs\UnfollowGenre;
use App\User;
use Dingo\Api\Http\Request;
use Eureka\Helpers\Transformers\CategoriesTransformer;
use Eureka\Repositories\CategoryRepository;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;

class CategoriesController extends PublicApiController
{

    protected $user;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param CategoryRepository $categoryRepository
     * @param Manager $fractal
     */
    public function __construct(CategoryRepository $categoryRepository, Manager $fractal)
    {
        $this->user = $this->auth()->user();
        $this->categoryRepository = $categoryRepository;
        $this->fractal = $fractal->setSerializer(new ArraySerializer());
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        $categories = $this->categoryRepository->getAll()->toArray();
//        $categories = $this->fractal->createData(new Collection($categories, new CategoriesTransformer))
//            ->toArray();
        return $this->response->array($categories)->setStatusCode(200);
    }

    /**
     * @param $genreId
     * @param Request $request
     * @param NotificationServiceInterface $interface
     * @return JsonResponse
     * @throws Exception
     */
    public function follow($genreId, Request $request, NotificationServiceInterface $interface)
    {

        $user_gcm_reg_token = $request->get('token');
        $genre = $this->categoryRepository->getCategory($genreId);

//        dd($user_gcm_reg_token, $genre);
        try{
            $this->dispatch(new FollowGenre($genre, $this->user, $user_gcm_reg_token));
//            $res = $interface->ptest($user_gcm_reg_token, ['title'=>'test one', 'body'=>'no body', 'event'=>'no-event']);
//            dd($res);
            return $this->respondForAction("success", 200, "category followed successfully");
        }catch (Exception $e){
//            throw $e;
            return $this->respondForAction("error", $e->getCode());
        }
    }

    /**
     * @param $genreId
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function unFollow($genreId, Request $request)
    {
        $user_gcm_reg_token = $request->get('token');
        $genre = $this->categoryRepository->getCategory($genreId);
        try{
            $this->dispatch(new UnfollowGenre($genre, $this->user, $user_gcm_reg_token));
            return $this->respondForAction("success", 200, "category unfollowed successfully");
        }catch (Exception $e){
            return $this->respondForAction("error", $e->getCode());
        }
    }

    /**
     * @param Request $request
     */
    public function bulkFollow(Request $request)
    {
        $this->dispatch(new followManyGenres($request->get('categoryIds')));
    }
}