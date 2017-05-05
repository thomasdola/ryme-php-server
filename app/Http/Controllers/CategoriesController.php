<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Eureka\Repositories\ArtistRepository;
use Eureka\Repositories\CategoryRepository;
use Eureka\Repositories\TrackRepository;
use League\Fractal\Manager;

/**
 * Class CategoriesController
 * @package App\Http\Controllers
 */
class CategoriesController extends Controller
{
    /**
     * @var ArtistRepository
     */
    private $artistRepository;
    /**
     * @var TrackRepository
     */
    private $trackRepository;
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
     * @param ArtistRepository $artistRepository
     * @param TrackRepository $trackRepository
     * @internal param Manager $fractal
     * @internal param Category $category
     */
    public function __construct(CategoryRepository $categoryRepository,
                                ArtistRepository $artistRepository,
                                TrackRepository $trackRepository)
    {
        $this->artistRepository = $artistRepository;
        $this->trackRepository = $trackRepository;
        $this->categoryRepository = $categoryRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory($id)
    {
        $category = $this->categoryRepository->getCategory($id);
        $trendingArtists = $this->categoryRepository->getTrendingArtistsByCategory($category->id);
        $trendingTracks = $this->categoryRepository->getCategoryTrendingTracks($category->id);
        return response()->json([
            'category' => $category,
            'trendingTracks' => $trendingTracks,
            'trendingArtists' => $trendingArtists
        ]);
    }
}
