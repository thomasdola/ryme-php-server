<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Role;
use Eureka\Helpers\Transformers\StaffTransformer;
use Eureka\Repositories\StaffRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class StaffController extends Controller
{


    /**
     *internal api base url
     */
    const BASE_URL = "localhost:8000/api";

    const RESOURCE_KEY = 'staff';
    /**
     * @var StaffRepository
     */
    private $staffRepository;
    /**
     * @var Role
     */
    private $role;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param StaffRepository $staffRepository
     * @param Role $role
     * @param Manager $fractal
     */
    public function __construct(StaffRepository $staffRepository, Role $role, Manager $fractal){
        $this->staffRepository = $staffRepository;
        $this->role = $role;
        $this->fractal = $fractal->setSerializer(new JsonApiSerializer(self::BASE_URL));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        $staffs = $this->staffRepository->getAllStaffs();
        $data =  $this->fractal->createData(
            new Collection($staffs, new StaffTransformer, self::RESOURCE_KEY))
            ->toArray();
        return response()->json($data);
    }

    /**
     * @param $id
     * @return Item
     */
    public function show($id)
    {
        $staff = $this->staffRepository->getStaffByUuid($id);
        $data =  $this->fractal->createData(
            new Item($staff, new StaffTransformer, self::RESOURCE_KEY))
            ->toArray();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $staff =  $this->staffRepository->addStaff($request->all());
        $data = $this->fractal->createData(
            new Item($staff, new StaffTransformer, self::RESOURCE_KEY))
            ->toArray();
        return response()->json($data);
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
//        $staff = $this->staffRepository->editStaff($request->all(), $id);
//        $data = $this->fractal->createData(
//            new Item($staff, new StaffTransformer, self::RESOURCE_KEY))
//            ->toArray();
//        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = $this->staffRepository->deleteStaff($id);
        $data = $this->fractal->createData(
            new Item($staff, new StaffTransformer, self::RESOURCE_KEY))
            ->toArray();
        return response()->json($data);
    }
}
