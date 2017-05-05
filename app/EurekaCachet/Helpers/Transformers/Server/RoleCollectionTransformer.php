<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 5:30 PM
 */

namespace Eureka\Helpers\Transformers\Server;


use App\Role;
use League\Fractal\TransformerAbstract;

class RoleCollectionTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id'=>(int) $role->id,
            'title'=>$role->title,
            'staff'=>(int) $role->staffs->count()
        ];
    }
}