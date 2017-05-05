<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 4/4/2016
 * Time: 12:56 PM
 */

namespace Eureka\Helpers\Transformers\Server;


use App\Vouch;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class RequestTransformer extends TransformerAbstract
{
    public function transform(Vouch $vouch)
    {
        return [
            'stage_name' => $vouch->user->stage_name,
            'genre' => $vouch->user->category->title,
            'start_date' => Carbon::parse($vouch->start_date)->toFormattedDateString(),
            'end_date' => Carbon::parse($vouch->end_date)->toFormattedDateString()
        ];
    }
}