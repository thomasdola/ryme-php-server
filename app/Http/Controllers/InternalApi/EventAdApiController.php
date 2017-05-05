<?php

namespace App\Http\Controllers\InternalApi;


use Carbon\Carbon;
use DB;
use Eureka\Helpers\Transformers\Server\EventAdItemTransformer;
use Eureka\Repositories\EventAdRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;
use Webpatser\Uuid\Uuid;

class EventAdApiController extends InternalApiController
{
    const RESOURCE_KEY = 'events';
    /**
     * @var Manager
     */
    private $fractal;
    /**
     * @var EventAdRepository
     */
    private $eventAdRepository;

    public function __construct(Manager $fractal, EventAdRepository $eventAdRepository){
        $this->fractal = $fractal->setSerializer(new DataArraySerializer());
        $this->eventAdRepository = $eventAdRepository;
    }
    
    public function all()
    {
        $ads = $this->eventAdRepository->getAll();
        $data = $this->fractal->createData(new Collection($ads,
            new EventAdItemTransformer, self::RESOURCE_KEY))->toArray();
        return response()->json($data);
    }

    public function single($id)
    {
        $ad = $this->eventAdRepository->getSingle($id);
        return $this->returnResponse($ad);
    }

    public function update($id, Request $data)
    {
        $ad = $this->eventAdRepository->update($id, $data);
        return $this->returnResponse($ad);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $file = $request->file;
        $file_name = $request->title.Carbon::now()->timestamp;
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();
        $date_time = Carbon::parse($request->date_time);
        $local_file = $this->moveToLocal($file, $file_name, self::ADS_UPLOADS_PATH);
        $full_path = $this->getFullPath($local_file, self::ADS_UPLOADS_PATH);
        $payload = array_add($request->only(['title', 'venue', 'description', 'fare']),
            'uuid', Uuid::generate(4));
        $payload = array_add(array_add($payload, 'end_date', $end_date), 'start_date', $start_date);
        $payload = array_add($payload, 'date_time', $date_time);

        DB::beginTransaction();
        $event_ad = $this->eventAdRepository->addEvent($payload);
        $event_ad->sections()->attach(explode(',', $request->section_ids));
        $event_ad->categories()->attach(explode(',', $request->category_ids));
        $event_ad->photo()->create([
            'path'=>$full_path,
            'uuid'=>Uuid::generate(4),
            'extension'=>$file->getClientOriginalExtension()
        ]);
        DB::commit();
        $data = $this->fractal->createData(new Item($event_ad,
            new EventAdItemTransformer))->toArray();
        return response()->json($data);
    }

    /**
     * @param $ad
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnResponse($ad)
    {
        $data = $this->fractal->createData(new Item($ad,
            new EventAdItemTransformer, self::RESOURCE_KEY))->toArray();
        return response()->json($data);
    }
}