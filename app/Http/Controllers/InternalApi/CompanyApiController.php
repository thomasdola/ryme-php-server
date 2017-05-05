<?php

namespace App\Http\Controllers\InternalApi;


use Eureka\Helpers\Transformers\Server\CompanyCollectionTransformer;
use Eureka\Repositories\CompaniesRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Webpatser\Uuid\Uuid;

class CompanyApiController extends InternalApiController
{
    /**
     * @var Manager
     */
    private $fractal;
    /**
     * @var CompaniesRepository
     */
    private $companiesRepository;

    public function __construct(Manager $fractal, CompaniesRepository $companiesRepository){
        $this->fractal = $fractal;
        $this->companiesRepository = $companiesRepository;
    }

    public function all()
    {
        $companies = $this->companiesRepository->getAll();
        $data = $this->fractal->createData(new Collection($companies, new CompanyCollectionTransformer))->toArray();
        return response()->json($data);
    }

    public function single($id)
    {
        $company = $this->companiesRepository->getSingle($id);
    }

    public function update($id, Request $request)
    {
        $company = $this->companiesRepository->update($id, $request->all());
    }

    public function store(Request $request)
    {
        $payload = array_add($request->only('name'), 'uuid', Uuid::generate(4));
        $company = $this->companiesRepository->addCompany($payload);
        $data = $this->fractal->createData(new Item($company, new CompanyCollectionTransformer))->toArray();
        return response()->json($data);
    }

    public function delete($id)
    {
        $company = $this->companiesRepository->delete($id);
    }
}