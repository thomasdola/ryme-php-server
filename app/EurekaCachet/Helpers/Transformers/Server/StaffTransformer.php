<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/18/2016
 * Time: 7:07 AM
 */

namespace Eureka\Helpers\Transformers\Server;

use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class StaffTransformer
 * @package Eureka\Helpers\Transformers
 */
class StaffTransformer extends TransformerAbstract
{
    /**
     * @param User $staff
     * @return array
     */
    public function transform(User $staff)
    {
        return [
            'id' => $staff->uuid,
            'name' => $staff->name,
            'email' => $staff->email,
            'role' => [
                'id' => $staff->role->id,
                'title' => $staff->role->title
            ]
        ];
    }
}