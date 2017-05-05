<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/8/2016
 * Time: 8:17 PM
 */

namespace Eureka\Repositories;


use App\Track;
use App\User;
use Carbon\Carbon;

/**
 * Class TrackRepository
 * @package Eureka\Repositories
 */
class TrackRepository
{

    /**
     * @var Track
     */
    private $track;
    /**
     * @var User
     */
    private $user;
    /**
     * @var ArtistRepository
     */
    private $artistRepository;

    /**
     * @param Track $track
     * @param User $user
     * @param ArtistRepository $artistRepository
     */
    public function __construct(Track $track, User $user, ArtistRepository $artistRepository){
        $this->track = $track;
        $this->user = $user;
        $this->artistRepository = $artistRepository;
    }

    /**
     * @return mixed
     */
    public function getTrendingTracks()
    {
        $tracks = $this->track->with('streams', 'author', 'genre',
            'usersWhoDownloaded', 'usersWhoLiked', 'comments')
            ->get();
        $tracks = $tracks->sortByDesc(function($track)
        {
            return $track->streams->count();
        });
        return $tracks;
    }

    /**
     * @return int
     */
    public function getAllTracksCount()
    {
        return $this->track->all()->count();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTrendingTracksByArtist($id)
    {
        $artist = $this->artistRepository->getArtist($id);
        $tracks = $this->track->with('artist', 'favorites', 'streams', 'downloads', 'comments')
            ->where('user_id', $artist->id)->get();
        $trendingOnes = $tracks->sortByDesc(function($track){
            return $track->streams->count();
        });
        return $trendingOnes;
    }

    /**
     * @param $id
     * @return static
     */
    public function getTrendingTracksByCategory($id)
    {
        $tracks = $this->track->with('artist', 'favorites', 'streams', 'downloads', 'comments')
            ->where('category_id', $id)->get();
        $trendingOnes = $tracks->sortByDesc(function($track){
            return $track->streams->count();
        });
        return $trendingOnes;
    }

    /**
     * @param $trackId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getTrackWithRelations($trackId)
    {
        return $this->track
            ->with('author', 'usersWhoDownloaded', 'usersWhoLiked',
                'comments', 'genre', 'streams', 'cover', 'file')
            ->where('uuid', $trackId)
            ->first();
    }

    /**
     * @param $trackId
     * @return mixed
     */
    public function getTrack($trackId)
    {
        $track = $this->track->where('uuid', $trackId)->first();
        return $track;
    }

    /**
     * @param $artistId
     * @return mixed
     */
    public function getAllTracksByArtist($artistId)
    {
        $artist = $this->user->where('uuid', $artistId)->first();
        return $artist->uploadedTracks;
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function getArtistNewTracks($uuid)
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        return $this->getTracksBetweenForThisArtist($uuid, $start, $end);
    }

    /**
     * @param $uuid
     * @param $start
     * @param $end
     * @return mixed
     */
    private function getTracksBetweenForThisArtist($uuid, $start, $end)
    {
        $artist = $this->artistRepository->getArtist($uuid);
        return $this->track->where("user_id", $artist->id)
            ->whereBetween("released_date", [$start, $end])->get();
    }
}