<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 3/8/2016
 * Time: 9:59 PM
 */

namespace Eureka\Helpers\Transformers\Server;


use App\Company;
use League\Fractal\TransformerAbstract;

class CompanyCollectionTransformer extends TransformerAbstract
{
    public function transform(Company $company)
    {
        return [
            'id' => $company->id,
            'uuid' => $company->uuid,
            'name' => $company->name
        ];
    }
}