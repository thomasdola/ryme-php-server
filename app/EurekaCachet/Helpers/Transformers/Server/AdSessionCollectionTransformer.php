<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 3/9/2016
 * Time: 9:00 AM
 */

namespace Eureka\Helpers\Transformers\Server;


use App\AdSection;
use App\AdSession;
use League\Fractal\TransformerAbstract;

class AdSessionCollectionTransformer extends TransformerAbstract
{
    public function transform(AdSection $session){
        return [
            'name' => strtoupper($session->name),
            'id' => $session->id
        ];
    }
}