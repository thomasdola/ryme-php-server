<?php
namespace App\Http\Controllers\InternalApi;

use Eureka\Helpers\Transformers\Server\TrackCollectionTransformer;
use Eureka\Repositories\TrackRepository;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;

class TrackApiController extends InternalApiController
{
    /**
     * @var Manager
     */
    private $fractal;
    /**
     * @var TrackRepository
     */
    private $trackRepository;

    public function __construct(Manager $fractal, TrackRepository $trackRepository){
        $this->fractal = $fractal->setSerializer(new DataArraySerializer());
        $this->trackRepository = $trackRepository;
    }

    public function getTrendingTrackByCategory($id)
    {
        return $this->fractal->createData(
            new Collection($this->trackRepository->getTrendingTracksByCategory($id),
                new TrackCollectionTransformer, 'tracks'))->toArray();
    }

    public function getTrendingTracksByArtist($id)
    {
        return $this->fractal->createData(
            new Collection($this->trackRepository->getTrendingTracksByArtist($id),
                new TrackCollectionTransformer, 'tracks'))->toArray();
    }

    public function getTrendingTracks()
    {
        return $this->fractal->createData(
            new Collection($this->trackRepository->getTrendingTracks(),
                new TrackCollectionTransformer, 'tracks'))->toArray();
    }

    public function totalTracks()
    {
        $allTracksCount = $this->trackRepository->getAllTracksCount();
        return response()->json([
            'title' => 'tracks',
            'total' => $allTracksCount
        ])->setStatusCode(200);
    }
}