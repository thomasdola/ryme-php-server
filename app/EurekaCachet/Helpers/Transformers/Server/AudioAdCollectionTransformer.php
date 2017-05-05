<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 4:25 PM
 */

namespace Eureka\Helpers\Transformers\Server;


use App\Ad;
use League\Fractal\TransformerAbstract;

class AudioAdCollectionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['company'];

    public function transform(Ad $ad)
    {
        return [
            'id'=>$ad->uuid,
            'title'=>$ad->title,
            'startDate'=>$ad->start_date,
            'endDate'=>$ad->end_date,
            'totalStreams'=>(int) $ad->streams->count()
        ];
    }

    public function includeCompany(Ad $ad)
    {
        $company = $ad->company;
        return $this->item($company, function($company){
            return [
                'name'=>$company->name
            ];
        });
    }
}