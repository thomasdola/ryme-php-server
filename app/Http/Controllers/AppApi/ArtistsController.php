<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 6:48 PM
 */

namespace App\Http\Controllers\AppApi;


use App\Jobs\FollowArtist;
use App\Jobs\UnfollowArtist;
use App\Jobs\UploadTrack;
use Carbon\Carbon;
use Dingo\Api\Http\Request;
use Eureka\Helpers\Transformers\Mobile\MobileArtistItemTransformer;
use Eureka\Helpers\Utils\Mp3File;
use Eureka\Repositories\ArtistRepository;
use Eureka\Repositories\CategoryRepository;
use Exception;
use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArtistsController extends PublicApiController
{
    /**
     * @var ArtistRepository
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
     * @param ArtistRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param Manager $fractal
     */
    public function __construct(ArtistRepository $repository,
                                CategoryRepository $categoryRepository, Manager $fractal){
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->fractal = $fractal;
    }

    /**
     * @param $artistId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($artistId)
    {
        $artist = $this->repository->getArtistWithRelations($artistId);
        return $this->response->item($artist,
            new MobileArtistItemTransformer($this->auth->user()))->setStatusCode(200);
    }

    /**
     * @param $artistId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow($artistId, Request $request)
    {
        $user_gcm_reg_token = $request->get('token');
        $artist = $this->repository->getArtist($artistId);
        try {
            $this->dispatch(new FollowArtist($artist, $this->auth->user(), $user_gcm_reg_token));
            return $this->respondForAction("success");
        }catch (Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param $artistId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFollow($artistId, Request $request)
    {
        $user_gcm_reg_token = $request->get('token');
        $artist = $this->repository->getArtist($artistId);
        try{
            $this->dispatch(new UnfollowArtist($artist, $this->auth->user(), $user_gcm_reg_token));
            return $this->respondForAction("success");
        }catch (Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
//        dd($request->track);
//        if($request->track != null && $request->cover != null){
//            $this->moveToLocal($request->track, "track_file");
//            $this->moveToLocal($request->cover, "track_cover");
//            return $this->respondForAction("success", 200, "Track Uploaded Successfully.");
//        }
//        return $this->respondForAction("error", 401, "Track file not found");
        $audioData = $this->prepareAudioData($request);
        $job = new UploadTrack($audioData, $this->auth->user());
        try{
            $this->dispatch($job);
            return $this->respondForAction("success", 200, "Track Uploaded Successfully.");
        }catch (Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param UploadedFile $file
     * @param $file_name
     * @return mixed
     */
    private function moveToLocal(UploadedFile $file, $file_name)
    {
        $destinationPath = base_path() . '/public/users/uploads/';
        $ext = $file->getClientOriginalExtension();
        $fileName = $file_name . '.' . $ext;
        $local_file = $file->move($destinationPath, $fileName);
        return $local_file;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function prepareAudioData(Request $request)
    {
        $track = $request->track;
        $cover = $request->cover;
        $title = str_slug($request->title);
        $date = Carbon::parse($request->date);
//        $featurings = $this->multiexplode(["#"], $request->featurings);
        $category = $this->categoryRepository->getCategoryIdByName($request->category);
        $local_track = $this->moveToLocal($track, $title);
        $local_cover = $this->moveToLocal($cover, $title . "_cover");
        $track_path = $this->getFullPath($local_track);
        $cover_path = $this->getFullPath($local_cover);
        $length = $this->getTrackLength($local_track);
        $audioData = array_add($request->only('title', 'downloadable'), "track_full_path", $track_path);
        $audioData = array_add($audioData, "cover_full_path", $cover_path);
        $audioData = array_add($audioData, "released_date", $date);
//        $audioData = array_add($audioData, "featurings", $featurings);
        $audioData = array_add($audioData, "category_id", $category);
        $audioData = array_add($audioData, "length", $length);
        $audioData = array_add($audioData, "track_ext", $local_track->getExtension());
        $audioData = array_add($audioData, "cover_ext", $local_cover->getExtension());
        return $audioData;
    }

    /**
     * @param $delimiters
     * @param $string
     * @return array
     */
    private function multiexplode ($delimiters, $string) {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

    /**
     * @param File $local_track
     * @return float
     */
    private function getTrackLength(File $local_track)
    {
        $path_name = $local_track->getPathname();
        $mp3 = new Mp3File($path_name);
        $durTwo = $mp3->getDuration();
        return $durTwo * 1000;
    }

    /**
     * @param File $local_file
     * @return string
     */
    private function getFullPath(File $local_file)
    {
        $file_name = $local_file->getBasename();
        return $full_path = '/users/uploads/' . $file_name;
    }
}