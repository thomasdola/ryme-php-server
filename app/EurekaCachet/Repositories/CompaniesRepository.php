<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 12:43 PM
 */

namespace Eureka\Repositories;


use App\Company;

/**
 * Class CompaniesRepository
 * @package Eureka\Repositories
 */
class CompaniesRepository
{
    /**
     * @var Company
     */
    private $company;

    /**
     * @param Company $company
     */
    public function __construct(Company $company){
        $this->company = $company;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->company->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSingle($id)
    {
        $company = $this->company->where('uuid', $id)->first();
        return $company;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $company = $this->getSingle($id);
        $company->delete();
        return $company;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $company = $this->getSingle($id);
        $company = $company->fill($data);
        $company->save();
        return $company;
    }

    /**
     * @param $data
     * @return $this
     */
    public function addCompany($data)
    {
        $company = $this->company->create($data);
        return $company;
    }
}