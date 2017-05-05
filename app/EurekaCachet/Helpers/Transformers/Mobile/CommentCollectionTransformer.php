<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 2/28/2016
 * Time: 6:29 PM
 */

namespace Eureka\Helpers\Transformers\Mobile;


use App\Comment;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class CommentCollectionTransformer extends TransformerAbstract
{
    public function transform(Comment $comment){
        return [
            "username" => $this->getUsername($comment->user),
            "message" => $comment->body,
            "time" => Carbon::parse($comment->created_at)->timestamp * 1000,
            "userAvatar" => "http://192.168.74.1:8000" . $comment->user->photos->where('type', 'avatar')->first()
                ? $comment->user->photos->where('type', 'avatar')->first()->path : null,
        ];
    }

    private function getUsername($user)
    {
        if($user->is_artist){
            return $user->stage_name;
        }
        return $user->username;
    }
}