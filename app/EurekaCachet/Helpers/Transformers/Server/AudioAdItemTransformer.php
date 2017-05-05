<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 4:25 PM
 */

namespace Eureka\Helpers\Transformers\Server;


use App\Ad;
use App\AdSection;
use App\AdSession;
use App\Category;
use App\Company;
use App\File;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AudioAdItemTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['sections', 'categories'];

    public function transform(Ad $ad)
    {
        return [
            'id'=>$ad->uuid,
            'title'=>$ad->title,
            'startDate'=>Carbon::parse($ad->start_date)->toFormattedDateString(),
            'endDate'=>Carbon::parse($ad->end_date)->toFormattedDateString(),
            'totalStreams'=> $ad->streams->count(),
            'company' => strtoupper($ad->company->name),
            'active' => (boolean) $ad->is_active,
            'file' => $ad->file->path
        ];
    }

    public function includeSections(Ad $ad)
    {
        $sections = $ad->sections;
        return $this->collection($sections, function(AdSection $section){
            return [
                'name'=>$section->name
            ];
        });
    }

    public function includeCategories(Ad $ad)
    {
        $categories = $ad->categories;
        return $this->collection($categories, function(Category $category){
            return [
                'path' => $category->name
            ];
        });
    }
}