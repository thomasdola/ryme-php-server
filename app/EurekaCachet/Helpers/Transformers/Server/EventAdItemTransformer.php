<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 4:41 PM
 */

namespace Eureka\Helpers\Transformers\Server;


use App\AdSection;
use App\Category;
use App\Company;
use App\Event;
use App\Photo;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class EventAdItemTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['categories', 'sections'];

    public function transform(Event $event)
    {
        return [
            'id'=>$event->id,
            'uuid'=>$event->uuid,
            'title'=>$event->title,
            'venue'=>$event->venue,
            'is_active'=>(boolean)$event->is_active,
            'description'=>$event->description,
            'date_time'=>Carbon::parse($event->date_time)->toDayDateTimeString(),
            'start_date'=>Carbon::parse($event->start_date)->toFormattedDateString(),
            'end_date'=>Carbon::parse($event->end_date)->toFormattedDateString(),
            'views'=> $event->views->count(),
            'photo'=>$event->photo->path
        ];
    }

    public function includeCategories(Event $event)
    {
        $categories = $event->categories;
        return $this->collection($categories, function(Category $category){
            return [
                'name'=>$category->name
            ];
        });
    }

    public function includeSections(Event $event)
    {
        $sections = $event->sections;
        return $this->collection($sections, function(AdSection $section){
            return [
                'name'=>$section->name
            ];
        });
    }
}