<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 5:18 PM
 */

namespace Eureka\Repositories;


use App\Role;

/**
 * Class RolesRepository
 * @package Eureka\Repositories
 */
class RolesRepository
{
    /**
     * @var Role
     */
    private $role;

    /**
     * @param Role $role
     */
    public function __construct(Role $role){
        $this->role = $role;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->role->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSingle($id)
    {
        return $this->role->find($id);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $role = $this->getSingle($id);
        $role = $role->fill($data);
        $role->save();
        return $role;
    }

    /**
     * @param $data
     * @return static
     */
    public function create($data)
    {
        return $this->role->create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $role = $this->getSingle($id);
        $role->delete();
        return $role;
    }
}