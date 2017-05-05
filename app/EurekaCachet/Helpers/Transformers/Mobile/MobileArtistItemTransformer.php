<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 2/28/2016
 * Time: 6:46 PM
 */

namespace Eureka\Helpers\Transformers\Mobile;


use App\User;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class MobileArtistItemTransformer extends TransformerAbstract
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user){
        $this->user = $user;
    }

    public function transform(User $artist){
        return [
            "uuid" => $artist->uuid,
            "stage_name" => $artist->stage_name,
            "followers" => $artist->followers->count(),
            "profilePic" =>  $artist->photos->where('type', 'avatar')->first()
                ?"http://192.168.74.1:8000" . $artist->photos->where('type', 'avatar')->first()->path : null,
            "backPic" => $artist->photos->where('type', 'background')->first()
                ? "http://192.168.74.1:8000" . $artist->photos->where('type', 'background')->first()->path : null,
            "followed" => $this->dejaVu($artist->followers),
            "amTheOne" => $this->amI($artist->uuid)
        ];
    }

    private function dejaVu(Collection $followers)
    {
        $follower = $followers->where('user_id', (string)$this->user->id)->first();
        if($follower != null){
            return true;
        }else{
            return false;
        }
    }

    private function amI($uuid)
    {
        if($uuid == $this->user->uuid){
            return true;
        }
        return false;
    }
}