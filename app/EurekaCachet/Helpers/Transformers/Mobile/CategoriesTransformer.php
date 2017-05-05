<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 2/25/2016
 * Time: 11:38 AM
 */

namespace Eureka\Helpers\Transformers\Mobile;


use App\Category;
use League\Fractal\TransformerAbstract;

class CategoriesTransformer extends TransformerAbstract
{
    public function transform(Category $category){
        return [
            'uuid' => $category->uuid,
            'name' => $category->name
        ];
    }
}