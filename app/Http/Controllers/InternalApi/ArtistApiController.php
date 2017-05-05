<?php
namespace App\Http\Controllers\InternalApi;

use Eureka\Helpers\Transformers\Server\ArtistCollectionTransformer;
use Eureka\Helpers\Transformers\Server\ArtistItemTransformer;
use Eureka\Helpers\Transformers\Server\RequestTransformer;
use Eureka\Repositories\ArtistRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

/**
 * Class ArtistApiController
 * @package App\Http\Controllers\InternalApi
 */
class ArtistApiController extends InternalApiController
{
    /**
     *
     */
    const RESOURCE_KEY = 'artists';
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
        $this->fractal = $fractal->setSerializer(new DataArraySerializer());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $artists = $this->artistRepository->getAllArtists();
        $data = $this->fractal->createData(new Collection($artists,
            new ArtistCollectionTransformer))->toArray();
        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function single($id)
    {
        $artist = $this->artistRepository->getArtistWithRelations($id);

        if( ! $artist ){
            return response()->json(
                [
                    'status' => 300,
                    'text' => 'not resource found'
                ]
            );
        }
        $data = $this->fractal->createData(new Item($artist,
            new ArtistItemTransformer))->toArray();
        return response()->json($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getTrendingArtistsByCategory($id)
    {
        return $this->fractal->createData(
            new Collection($this->artistRepository->getTrendingArtistsByCategory($id),
                new ArtistCollectionTransformer))->toArray();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndexPageData()
    {
        $artistsJoinedToday = $this->artistRepository->getArtistJoinedTodayCount();
        $artistsJoinedThisWeek = $this->artistRepository->getArtistsJoinedThisWeekCount();
        $artistsJoinedThisMonth = $this->artistRepository->getArtistsJoinedThisMonthCount();
        $allArtistsCount = $this->artistRepository->getAllArtistsCount();
        return response()->json([
            [
                'title' => 'Artists Joined today',
                'total' => $artistsJoinedToday
            ],
            [
                'title' => 'Artists Joined this Week',
                'total' => $artistsJoinedThisWeek,
            ],
            [
                'title' => 'Artists Joined this month',
                'total' => $artistsJoinedThisMonth
            ],
            [
                'title' => 'Total Artists',
                'total' => $allArtistsCount
            ]
        ]);
    }

    public function trending()
    {
        return $this->fractal->createData(
            new Collection($this->artistRepository->getTrendingArtists(),
                new ArtistCollectionTransformer))->toArray();
//        return response()->json([
//            'data' => $trendingArtists
//        ]);
    }

    public function requests()
    {
        $artistToBe = $this->artistRepository->getArtistToBe();
//        dd($artistToBe->first()->user->end_date);
        return $this->fractal->createData(
            new Collection($artistToBe,
                new RequestTransformer))->toArray();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->q;
        $type = $request->type;
        if($type == 'users'){

        }
        $artist = $this->artistRepository->findArtistByName($query);
        return $this->fractal->createData(
            new Collection($artist,
                new ArtistCollectionTransformer))->toArray();
    }

    public function totalArtists()
    {
        $allArtistsCount = $this->artistRepository->getAllArtistsCount();
        return response()->json([
            'title' => 'artists',
            'total' => $allArtistsCount
        ])->setStatusCode(200);
    }

    public function topArtists()
    {
        return $this->fractal->createData(
            new Collection($this->artistRepository->getAllArtists(),
                new ArtistCollectionTransformer))->toArray();
    }
}