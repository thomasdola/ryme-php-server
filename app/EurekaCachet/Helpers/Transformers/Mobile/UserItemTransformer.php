<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 2/23/2016
 * Time: 8:21 PM
 */

namespace Eureka\Helpers\Transformers\Mobile;


use App\User;
use League\Fractal\TransformerAbstract;

class UserItemTransformer extends TransformerAbstract
{
    public function transform(User $user){
        return [
            "uuid" => $user->uuid,
            "username" => $user->username,
            "avatar" => $user->photos->where('type', 'avatar')->first()
                ?"http://192.168.74.1:8000" .  $user->photos->where('type', 'avatar')->first()->path : null,
            "is_artist" => (boolean)$user->is_artist,
            "phone_number" => $user->phone,
            "background_picture" => $user->photos->where('type', 'background')->first()
                ? "http://192.168.74.1:8000" . $user->photos->where('type', 'background')->first()->path : null,
            "is_request_on" => (boolean)$user->is_request_active,
            "stage_name" => $user->stage_name
        ];
    }
}