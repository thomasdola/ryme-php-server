<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 2/29/2016
 * Time: 2:19 PM
 */

namespace Eureka\Helpers\Transformers\Mobile;


use App\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ArtistRequestTransformer extends TransformerAbstract
{
    /**
     * @var User
     */
    private $searcher;

    /**
     * @param User $searcher
     */
    public function __construct(User $searcher){
        $this->searcher = $searcher;
    }
    public function transform(User $user){
        return [
            "stage_name" => $user->stage_name,
            "avatar" => $user->photos->where('type', 'avatar')->first()
                ? "http://192.168.74.1:8000". $user->photos->where('type', 'avatar')->first()->path : null,
            "uuid" => $user->vouchRequests->last()->uuid,
            "yes" => $user->vouchRequests->last()->responses->where('answer', '1')->count(),
            "no" => $user->vouchRequests->last()->responses->where('answer', '0')->count(),
            "start_date" => Carbon::parse($user->vouchRequests->last()->start_date)->timestamp * 1000,
            "end_date" => Carbon::parse($user->vouchRequests->last()->end_date)->timestamp * 1000,
            "artist_channel" => $user->channel,
            "deja_vu" => $this->dejaVu($user->vouchRequests->last()->id),
            "user_id" => $user->uuid
        ];
    }

    private function dejaVu($id)
    {
        $resps = $this->searcher->vouchResponses->all();
        if(!collect($resps)->isEmpty()){
            $data = collect($resps)->where('id', $id);
            if($data){
                return true;
            }
        }
        return false;
    }
}