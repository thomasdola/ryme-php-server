<?php

namespace App\Http\Controllers\InternalApi;


use Carbon\Carbon;
use DB;
use Eureka\Helpers\Transformers\Server\AudioAdCollectionTransformer;
use Eureka\Helpers\Transformers\Server\AudioAdItemTransformer;
use Eureka\Repositories\AudioAdRepository;
use Eureka\Repositories\CompaniesRepository;
use Eureka\Repositories\EventAdRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;
use Webpatser\Uuid\Uuid;

class AudioAdApiController extends InternalApiController
{
    /**
     * @var Manager
     */
    private $fractal;
    /**
     * @var AudioAdRepository
     */
    private $audioAdRepository;
    /**
     * @var EventAdRepository
     */
    private $eventAdRepository;
    /**
     * @var CompaniesRepository
     */
    private $companiesRepository;

    public function __construct(Manager $fractal, AudioAdRepository $audioAdRepository,
                                EventAdRepository $eventAdRepository, CompaniesRepository $companiesRepository){
        $this->fractal = $fractal->setSerializer(new DataArraySerializer());
        $this->audioAdRepository = $audioAdRepository;
        $this->eventAdRepository = $eventAdRepository;
        $this->companiesRepository = $companiesRepository;
    }

    public function all()
    {
        $activeAds = $this->audioAdRepository->getAds();
        $data = $this->fractal->createData(new Collection($activeAds,
            new AudioAdCollectionTransformer, 'ads'))->toArray();
        return response()->json($data);
    }

    public function single($id)
    {
        $ad = $this->audioAdRepository->getAd($id);
        $data = $this->fractal->createData(new Item($ad,
            new AudioAdItemTransformer, 'ads'))->toArray();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $file = $request->file;
        $file_name = $request->title.Carbon::now()->timestamp;
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();
        $local_file = $this->moveToLocal($request->file, $file_name, self::ADS_UPLOADS_PATH);
        $full_path = $this->getFullPath($local_file, self::ADS_UPLOADS_PATH);
        $payload = array_add($request->only(['company_id', 'title']), 'uuid', Uuid::generate(4));
        $payload = array_add($payload, 'start_date', $start_date);
        $payload = array_add($payload, 'end_date', $end_date);

        DB::beginTransaction();
        $audio_ad = $this->audioAdRepository->createAd($payload);
        $audio_ad->sections()->attach(explode(',', $request->section_ids));
        $audio_ad->categories()->attach(explode(',', $request->category_ids));
        $audio_ad->file()->create([
            'uuid'=>Uuid::generate(4),
            'path'=>$full_path,
            'extension'=>$file->getClientOriginalExtension()
        ]);
        DB::commit();

        $data = $this->fractal->createData(new Item($audio_ad,
            new AudioAdItemTransformer, 'ads'))->toArray();
        return response()->json($data);
    }

    public function update($id, $data)
    {
        $ad = $this->audioAdRepository->editAd($id, $data);
        $data = $this->fractal->createData(new Item($ad,
            new AudioAdItemTransformer, 'ads'))->toArray();
        return response()->json($data);
    }

    public function getIndexPageData()
    {
        $audioActiveCount = $this->audioAdRepository->getAds()->count();
        $eventActiveCount = $this->eventAdRepository->getAds()->count();
        $companiesCount = $this->companiesRepository->getAll()->count();
        return response()->json([
            'activeAudioAdsCount' => $audioActiveCount,
            'activeEventAdsCount' => $eventActiveCount,
            'companiesCount' => $companiesCount
        ]);
    }

    public function totalAds()
    {
        $audioActiveCount = $this->audioAdRepository->getAds()->count();
        return response()->json([
            'title' => 'active ads',
            'total' => $audioActiveCount
        ])->setStatusCode(200);
    }
}