<?php

namespace App\Http\Controllers\InternalApi;

use Eureka\Helpers\Transformers\Server\ArtistCollectionTransformer;
use Eureka\Helpers\Transformers\Server\UserCollectionTransformer;
use Eureka\Repositories\ArtistRepository;
use Eureka\Repositories\UserRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class SearchLocalApiController extends Controller
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
     * @var Manager
     */
    private $fractal;

    /**
     * @param ArtistRepository $artistRepository
     * @param UserRepository $userRepository
     * @param Manager $fractal
     */
    public function __construct(ArtistRepository $artistRepository,
                                UserRepository $userRepository, Manager $fractal){
        $this->userRepository = $userRepository;
        $this->artistRepository = $artistRepository;
        $this->fractal = $fractal;
    }

    public function search(Request $request)
    {
        $query = $request->q;
        $type = $request->type;
        if($type == 'users'){
            $users = $this->userRepository->findUserByName($query, true);
            return $this->fractal->createData(
                new Collection($users,
                    new UserCollectionTransformer))->toArray();
        }
        $artist = $this->artistRepository->findArtistByName($query);
        return $this->fractal->createData(
            new Collection($artist,
                new ArtistCollectionTransformer))->toArray();
    }
}
