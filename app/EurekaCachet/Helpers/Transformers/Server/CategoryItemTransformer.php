<?php

namespace Eureka\Helpers\Transformers\Server;


use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryItemTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['trendingTracks', 'trendingArtists'];

    public function transform(Category $category)
    {
        return [
            'name'=> $category->name,
            'id'=> $category->id,
            'uuid'=> $category->uuid,
            'totalArtists' => $category->artists->count(),
            'totalFollowers' => $category->followers->count(),
            'totalTracks' => $category->tracks->count()
        ];
    }

    public function includeTrendingTracks(Category $category)
    {
        $tracks = $category->tracks->sortByDesc(function($track){
            return $track->streams->count();
        });
        return $this->collection($tracks, new TrackCollectionTransformer, 'tracks');
    }

    public function includeTrendingArtists(Category $category)
    {
        $artists = $category->artists->sortByDesc(function($artist){
            return $artist->followers->count();
        });
        return $this->collection($artists, new ArtistCollectionTransformer, 'artists');
    }
}