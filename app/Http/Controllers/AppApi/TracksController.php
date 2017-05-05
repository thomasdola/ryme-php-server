<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 6:47 PM
 */

namespace App\Http\Controllers\AppApi;


use App\Jobs\DislikeTrack;
use App\Jobs\DownloadTrack;
use App\Jobs\LikeTrack;
use App\Jobs\StreamTrack;
use App\Jobs\UpdateTrackInfo;
use App\Track;
use App\User;
use Dingo\Api\Http\Request;
use Eureka\Helpers\Transformers\Mobile\MobileTrackCollectionTransformer;
use Eureka\Helpers\Transformers\Mobile\MobileTrackItemTransformer;
use Eureka\Repositories\ArtistRepository;
use Eureka\Repositories\CategoryRepository;
use Eureka\Repositories\TrackRepository;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Mockery\CountValidator\Exception;

class TracksController extends PublicApiController
{
    /**
     * @var TrackRepository
     */
    private $repository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Manager
     */
    private $fractal;
    /**
     * @var ArtistRepository
     */
    private $artistRepository;

    /**
     * @param TrackRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param Manager $fractal
     * @param ArtistRepository $artistRepository
     */
    public function __construct(TrackRepository $repository,
                                CategoryRepository $categoryRepository,
                                Manager $fractal, ArtistRepository $artistRepository){
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->fractal = $fractal;
        $this->artistRepository = $artistRepository;
    }

    public function lists(Request $request)
    {
        //['new', 'trending', 'all']
        $type = $request->get('type');
        if( ! $request->has("type")){
            return $this->respondForAction("error", 400, "Missing Parameter");
        }
        $tracks = [];
        if($type == "trending"){
            $tracks = $this->getTrendingTrackFor($this->auth->user());
        }elseif($type == "new"){
            $tracks = $this->getNewTracksFor($this->auth->user());
        }elseif($type == "all"){
//            $tracks = $this->getAllTracksFor($this->auth->user());
            $tracks = Track::all();
        }
        $tracks = $this->fractal->createData(new Collection($tracks,
            new MobileTrackCollectionTransformer($this->auth->user())))
            ->toArray();
//        dd($tracks);
        return $tracks;
    }

    public function artistTracks($uuid, Request $request)
    {
        if(!$request->has('type')){
            return $this->respondForAction("error", 400, "missing parameter");
        }
        $tracks = [];
        $type = $request->get('type');
        if($type == "all"){
            $tracks = $this->getArtistAllTracks($uuid);
        }elseif($type == "new"){
            $tracks = $this->getArtistNewTracks($uuid);
        }
        $tracks = $this->fractal->createData(new Collection($tracks,
            new MobileTrackCollectionTransformer($this->auth->user())))
            ->toArray();
        return $this->response->array($tracks)->setStatusCode(200);
    }

    public function show($trackId)
    {
        $track = $this->repository->getTrackWithRelations($trackId);
        if(!$track) return $this->respondForData("error", 404, "No track found");
        $track = $this->fractal->createData(new Item($track,
            new MobileTrackCollectionTransformer($this->auth->user())))->toArray();
        return $this->respondForDataMerge("success", 200, "succeeded", $track);
    }

    public function stream($trackId)
    {
        $track = $this->repository->getTrack($trackId);
        $this->dispatch(new StreamTrack($track));
    }

    public function like($trackId)
    {
        $track = $this->repository->getTrack($trackId);
        try{
            $this->dispatch(new LikeTrack($track, $this->auth->user()));
            return $this->respondForAction("success");
        }catch (Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    public function dislike($trackId)
    {
        $track = $this->repository->getTrack($trackId);
        try{
            $this->dispatch(new DislikeTrack($track, $this->auth->user()));
            return $this->respondForAction("success");
        }catch (Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    public function download($trackId)
    {
        $track = $this->repository->getTrack($trackId);
        $this->dispatch(new DownloadTrack($track));
    }

    public function updateInfo(Request $request, $uuid){
        if(!$request->has("downloadable")) return $this
            ->respondForAction("error", 400, "missing argument -> downloadable");
        try{
            $this->dispatch(new UpdateTrackInfo($uuid, $request->get("downloadable")));
            return $this->respondForAction("success", 200);
        }catch (Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param User $user
     * @return array
     */
    private function getTrendingTrackFor(User $user)
    {
        $tracks = collect([]);
        $categories = $this->getUserCategories($user);
        foreach($categories as $category){
            $items = $this->categoryRepository->getCategoryTrendingTracks($category->followable_id);
            $tracks->push($items);
        }
        return $tracks->unique()
            ->flatten()
            ->filter(function(Track $track){
                return $track->streams->count() >= 100;
            })
            ->sortByDesc(function($track){
                $track->streams->count();
            })
            ->take(100)
            ->all();
    }

    /**
     * @param User $user
     * @return array
     */
    private function getNewTracksFor(User $user)
    {
        $tracks = collect([]);
        $categories = $this->getUserCategories($user);
        foreach($categories as $category){
            $items = $this->categoryRepository->getCategoryNewTracks($category->followable_id);
            $tracks->push($items);
        }
        return $tracks->flatten()->unique()->all();
    }

    /**
     * @param User $user
     * @return static
     */
    private function getUserCategories(User $user)
    {
        return $user->followings->where("followable_type", 'App\Category')->all();
    }

    private function getAllTracksFor($user)
    {
        return $this->getNewTracksFor($user);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    private function getArtistAllTracks($uuid)
    {
        $artist = $this->artistRepository->getArtist($uuid);
        return $artist->uploadedTracks->sortByDesc("created_at")->all();
    }

    private function getArtistTrendingTracks($uuid)
    {
        $artist = $this->artistRepository->getArtist($uuid);
        $this->repository->getTrendingTracksByArtist($uuid);
    }

    private function getArtistNewTracks($uuid)
    {
        return $this->repository->getArtistNewTracks($uuid);
    }
}