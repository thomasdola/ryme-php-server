<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/10/2016
 * Time: 10:14 AM
 */

namespace Eureka\Repositories;


use App\Company;
use Webpatser\Uuid\Uuid;

class CompanyRepository
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

    public function addCompany($data)
    {
        $uuid = Uuid::generate(4);
        $payload = array_add($data, 'uuid', $uuid);
        return $this->company->create($payload);
    }

    public function getAllCompaniesCount()
    {
        return $this->getAllCompanies()->count();
    }

    private function getAllCompanies()
    {
       return $this->company->all();
    }

}