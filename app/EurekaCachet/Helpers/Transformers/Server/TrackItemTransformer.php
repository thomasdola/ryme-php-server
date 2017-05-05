<?php

namespace Eureka\Helpers\Transformers\Server;


use App\Track;
use League\Fractal\TransformerAbstract;

class TrackItemTransformer extends TransformerAbstract
{
    public function transform(Track $track)
    {
        return [
            'title' => $track->title,
            'id' => $track->uuid,
            'genre' => new Item($track->category, new CategoryTransformer, 'categories'),
            'artist' => new Item($track->artist, new ArtistTransformer, 'artists'),
            'released_date' => Carbon::parse($track->released_date)->timestamp
        ];
    }
}