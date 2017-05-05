<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Jobs\UploadTrack;
use Eureka\Repositories\AdRepository;
use Eureka\Repositories\ArtistRepository;
use Eureka\Repositories\TrackRepository;
use Eureka\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class PagesController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ArtistRepository
     */
    private $artistRepository;
    /**
     * @var AdRepository
     */
    private $adRepository;
    /**
     * @var TrackRepository
     */
    private $trackRepository;
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @param UserRepository $userRepository
     * @param ArtistRepository $artistRepository
     * @param AdRepository $adRepository
     * @param TrackRepository $trackRepository
     * @param Manager $manager
     */
    public function __construct(UserRepository $userRepository, ArtistRepository $artistRepository,
                                AdRepository $adRepository, TrackRepository $trackRepository,
                                Manager $manager){
        $this->userRepository = $userRepository;
        $this->artistRepository = $artistRepository;
        $this->adRepository = $adRepository;
        $this->trackRepository = $trackRepository;
        $this->manager = $manager->setSerializer(new JsonApiSerializer());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(Request $request)
    {

//        dd($request->all());
        $data = [
            'title'=>'Kai Kai',
            'album'=>null,
            'category_id'=>'2',
            'cover'=>'cover.jpeg',
            'released_date'=>'10/02/2016'
        ];

//        dd(mt_rand(1000, 9999));

        $audioData = collect($data);
//        $artist = Auth::user();

//        ArtistActivitiesService::using($artist)->uploadTrack($audioData);
//        $uploadTrack = new UploadTrack($audioData);
//        $this->dispatch($uploadTrack);
//        dd(Auth::user());
        return view('pages.welcome', ['tracks'=>[]]);
    }

    public function getDashboardData()
    {
        $allUsersCount = $this->userRepository->getAllUsersCount();
        $allArtistsCount = $this->artistRepository->getAllArtistsCount();
        $allTracksCount = $this->trackRepository->getAllTracksCount();
        $allActiveAdsCount = $this->adRepository->getAllActiveAdsCount();
        $trendingArtists = $this->artistRepository->getTrendingArtists();
        $trendingTracks = $this->trackRepository->getTrendingTracks();
        return response()->json([
            'users' => [
                'title'=>'users',
                'total'=>$allUsersCount,
            ],
            'artists'=>[
                'total'=>$allArtistsCount,
                'title'=>'artists'
            ],
            'tracks'=>[
                'total'=>$allTracksCount,
                'title'=>'tracks'
            ],
            'activeAds'=>[
                'total'=>$allActiveAdsCount,
                'title'=>'activeAds'
            ],
            'trendingTracks'=>$trendingTracks,
            'trendingArtists'=>$trendingArtists
        ]);
    }
}
