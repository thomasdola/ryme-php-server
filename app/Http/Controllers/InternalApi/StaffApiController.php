<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 5:13 PM
 */

namespace App\Http\Controllers\InternalApi;


use Eureka\Helpers\Transformers\Server\StaffTransformer;
use Eureka\Repositories\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

class StaffApiController extends InternalApiController
{
    /**
     * @var StaffRepository
     */
    private $staffRepository;
    /**
     * @var Manager
     */
    private $fractal;

    public function __construct(StaffRepository $staffRepository, Manager $fractal){
        $this->staffRepository = $staffRepository;
        $this->fractal = $fractal->setSerializer(new DataArraySerializer);
    }

    /**
     * @return array
     */
    public function all()
    {
        $staffs = $this->staffRepository->getAllStaffs();
        return $this->fractal->createData(new Collection($staffs,
            new StaffTransformer))->toArray();
    }

    /**
     * @param $id
     * @return array
     */
    public function single($id)
    {
        $staff = $this->staffRepository->getStaffByUuid($id);
        return $this->fractal->createData(new Item($staff,
            new StaffTransformer))->toArray();
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($id, Request $request)
    {
        $type = $request->get('type');
        if($type == 'password'){
            $this->validate($request, [
                'old_password' => 'required',
                'new_password' => 'required|min:10',
                'new_password_confirmation' => 'confirmed',
            ]);
        }elseif($type == 'email'){
            $this->validate($request, [
                'email' => 'required|unique:users'
            ]);
        }else{
            $this->validate($request, [
                'email' => 'required|unique:users',
                'name' => 'required'
            ]);
        }

        $staff = $this->staffRepository->editStaff($request->all(), $id, $type);
        if( ! $staff){
            session()->flash('error', 'Invalid Password');
            return redirect()->back();
        }
        return $this->fractal->createData(new Item($staff,
            new StaffTransformer))->toArray();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $staff = $this->staffRepository->addStaff($request->all());
        return $this->fractal->createData(new Item($staff,
            new StaffTransformer))->toArray();
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $staff = $this->staffRepository->deleteStaff($id);
        return $this->fractal->createData(new Item($staff,
            new StaffTransformer))->toArray();
    }
}