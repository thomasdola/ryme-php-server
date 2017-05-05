<?php

namespace App\Http\Controllers\InternalApi;

use App\AdSection;
use App\AdSession;
use Carbon\Carbon;
use Eureka\Helpers\Transformers\Server\AdSessionCollectionTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class AdSessionsController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal){
        $this->fractal = $fractal;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = $this->fractal->createData(new Collection(AdSection::all(),
            new AdSessionCollectionTransformer))->toArray();
        return response()->json($sessions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $payload = array_add(array_add($request->only('name'), 'start_time', $start), 'end_time', $end);
        $session = $this->fractal->createData(new Item(AdSection::create($payload),
            new AdSessionCollectionTransformer))->toArray();
        return response()->json($session);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payload = [];
        if($request->has('name')){
            $payload = array_add($payload, 'name', $request->name);
        }elseif($request->has('start')){
            $payload = array_add($payload, 'start_time', Carbon::parse($request->start));
        }elseif($request->has('end')){
            $payload = array_add($payload, 'end_time', Carbon::parse($request->end));
        }
        if(! AdSection::find($id)->update($payload)){
            return response("error", 404);
        }else{
            $session = $this->fractal->createData(new Item(AdSection::find($id),
                new AdSessionCollectionTransformer))->toArray();
            return response()->json($session);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session = AdSection::find($id);
        if(!$session->delete()){
            return response('error', 404);
        }
        return response()->json($this->fractal->createData(
            new Item($session, new AdSessionCollectionTransformer))->toArray());
    }
}
