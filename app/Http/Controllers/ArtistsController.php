<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Eureka\Helpers\Transformers\Server\ArtistItemTransformer;
use Eureka\Helpers\Transformers\Server\TrackCollectionTransformer;
use Eureka\Repositories\ArtistRepository;
use Eureka\Repositories\TrackRepository;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ArtistsController extends Controller
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
     * @var TrackRepository
     */
    private $trackRepository;

    /**
     * @param ArtistRepository $artistRepository
     * @param TrackRepository $trackRepository
     * @param Manager $fractal
     */
    public function __construct(ArtistRepository $artistRepository, TrackRepository $trackRepository,
                                Manager $fractal){
        $this->artistRepository = $artistRepository;
        $this->fractal = $fractal;
        $this->trackRepository = $trackRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('artists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = $this->artistRepository->getArtist($id);
        $tracks = $this->trackRepository->getAllTracksByArtist($id);
        $artist = $this->fractal->createData(new Item($artist,
            new ArtistItemTransformer))->toArray();
        $tracks = $this->fractal->createData(new Collection($tracks,
            new TrackCollectionTransformer))->toArray();
//        dd($tracks['data']);
        return view("artists.show", [
            'artist' => collect($artist['data']),
            'tracks' => $tracks['data']
        ]);
    }
}
