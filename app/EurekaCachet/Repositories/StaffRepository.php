<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/10/2016
 * Time: 12:11 PM
 */

namespace Eureka\Repositories;


use App\User;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class StaffRepository
{

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function getAllStaffs()
    {
        return $this->user->with('role')->where('type', 'staff')
            ->get();
    }

    public function addStaff($data)
    {
        $uuid = Uuid::generate(4);
        $payload = array_add($data, 'uuid', $uuid);
        $payload = array_add($payload, 'gender', 1);
        $payload = array_add($payload, 'type', 'staff');
        $payload = array_add($payload, 'password', bcrypt($data['email']));
        return $this->user->create($payload);
    }

    /**
     * @param $data
     * @param $id
     * @param $type
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function editStaff($data, $id, $type)
    {
        $staff = $this->getStaffByUuid($id);
        if($type == 'email'){
            $staff->update($data['email']);
            return $this->getStaffByUuid($id);
        }elseif($type == 'general'){
            $staff->update($data);
            return $this->getStaffByUuid($id);
        }
        $attempt = Auth::attemp(['email' => $staff->email, 'password' => $data['old_password']]);
        if( ! $attempt){
            return false;
        }
        $staff->update(['password' => $data['new_password']]);
        return $this->getStaffByUuid($id);
    }

    public function deleteStaff($id)
    {
        $staff = $this->getStaffByUuid($id);
        $staff->delete();
        return $staff;
    }

    public function getStaffByUuid($id)
    {
        return $this->user->with('role')
            ->where(['uuid'=>$id, 'type'=>'staff'])
            ->firstOrFail();
    }

}