<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/18/2016
 * Time: 7:06 AM
 */

namespace Eureka\Helpers\Transformers\Server;

use App\User;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
class ArtistItemTransformer extends TransformerAbstract
{
    public function transform(User $artist)
    {
        return [
            'id' => $artist->uuid,
            'name' => $artist->stage_name,
            'username' => $artist->username,
            'category' => [
                'name' => $artist->category->name,
                'id' => $artist->category->uuid
            ],
            'followers' => $artist->followers->count(),
            'tracks' => $artist->uploadedTracks->count(),
            "profilePic" =>  $artist->photos->where('type', 'avatar')->first()
                ? $artist->photos->where('type', 'avatar')->first()->path : null,
            "backPic" => $artist->photos->where('type', 'background')->first()
                ? $artist->photos->where('type', 'background')->first()->path : null,
        ];
    }
}