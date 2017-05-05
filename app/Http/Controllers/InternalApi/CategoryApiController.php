<?php
namespace App\Http\Controllers\InternalApi;

use Eureka\Helpers\Transformers\Server\CategoryCollectionTransformer;
use Eureka\Helpers\Transformers\Server\CategoryItemTransformer;
use Eureka\Repositories\ArtistRepository;
use Eureka\Repositories\CategoryRepository;
use Eureka\Repositories\TrackRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;
use Webpatser\Uuid\Uuid;

/**
 * Class CategoryApiController
 * @package App\Http\Controllers\InternalApi
 */
class CategoryApiController extends InternalApiController
{

    /**
     *
     */
    const RESOURCE_KEY = 'categories';
    /**
     * @var Manager
     */
    private $fractal;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ArtistRepository
     */
    private $artistRepository;
    /**
     * @var TrackRepository
     */
    private $trackRepository;
    /**
     * @var TrackApiController
     */
    private $trackApiController;
    /**
     * @var ArtistApiController
     */
    private $artistApiController;

    /**
     * @param Manager $fractal
     * @param CategoryRepository $categoryRepository
     * @param ArtistRepository $artistRepository
     * @param TrackRepository $trackRepository
     * @param TrackApiController $trackApiController
     * @param ArtistApiController $artistApiController
     */
    public function __construct(Manager $fractal, CategoryRepository $categoryRepository,
                                ArtistRepository $artistRepository, TrackRepository $trackRepository,
                                TrackApiController $trackApiController, ArtistApiController $artistApiController)
    {
        $this->categoryRepository = $categoryRepository;
        $this->artistRepository = $artistRepository;
        $this->trackRepository = $trackRepository;
        $this->fractal = $fractal->setSerializer(new ArraySerializer());
        $this->trackApiController = $trackApiController;
        $this->artistApiController = $artistApiController;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $categories = $this->categoryRepository->getAll();
        $data = $this->fractal->createData(new Collection($categories,
            new CategoryCollectionTransformer, self::RESOURCE_KEY))->toArray();
        return response()->json($data);
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function single($uuid)
    {
        $data = null;
        $category = $this->categoryRepository->getCategory($uuid);
        if( ! $category ){
            $data = ['status' => '300', 'text'=>'not found'];
        }else{
            $data = $this->fractal->createData(new Item($category,
                new CategoryItemTransformer, self::RESOURCE_KEY))->toArray();
        }
        return response()->json($data);
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function singleWithRelations($uuid)
    {
        $category = $this->fractal->createData(new Item($this->categoryRepository->getCategory($uuid),
            new CategoryItemTransformer(), self::RESOURCE_KEY))->toArray();
        $trendingArtists = $this->artistApiController->getTrendingArtistsByCategory($category->id);
        $trendingTracks = $this->trackApiController->getTrendingTrackByCategory($category->id);
        return response()->json([
            'category' => $category,
            'trendingTracks' => $trendingTracks,
            'trendingArtists' => $trendingArtists
        ]);
    }

    /**
     * @param $uuid
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($uuid, Request $request)
    {
        $category = $this->categoryRepository->updateCategory($uuid, $request->all());
        $data = $this->fractal->createData(new Item($category,
            new CategoryItemTransformer(), self::RESOURCE_KEY))->toArray();
        return response()->json($data);
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($uuid)
    {
        $category = $this->categoryRepository->deleteCategory($uuid);
        return response()->json(['status'=>200]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $payload = $request->only("name");
        $payload = array_add($payload, "uuid", Uuid::generate(4));
        $category = $this->categoryRepository->addCategory($payload);
        $channelData = $this->getChannelData($category);
        $category->channel()->create($channelData);
        $data = $this->fractal->createData(new Item($category,
            new CategoryCollectionTransformer, self::RESOURCE_KEY))->toArray();
        return response()->json($data);
    }

    /**
     * @param $category
     * @return array
     * @throws \Exception
     */
    private function getChannelData($category)
    {
        return ['name' => $category->name . "-channel", "uuid" => Uuid::generate(4)];
    }
}