<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/18/2016
 * Time: 7:06 AM
 */

namespace Eureka\Helpers\Transformers\Server;

use App\User;
use League\Fractal\TransformerAbstract;

class ArtistCollectionTransformer extends TransformerAbstract
{
    public function transform(User $artist)
    {
        return [
            'id' => $artist->uuid,
            'name' => $artist->stage_name,
            "profilePic" =>  $artist->photos->where('type', 'avatar')->first()
                ?"localhost:8000". $artist->photos->where('type', 'avatar')->first()->path : null,
            "backPic" => $artist->photos->where('type', 'background')->first()
                ?"localhost:8000". $artist->photos->where('type', 'background')->first()->path : null,
            'followers' => $artist->followers->count(),
            'tracks' => $artist->uploadedTracks->count(),
            'genre' => $artist->category->name,
            'is_artist' => (boolean)$artist->is_artist
        ];
    }
}