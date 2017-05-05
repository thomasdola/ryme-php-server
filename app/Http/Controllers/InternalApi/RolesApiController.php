<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 5:17 PM
 */

namespace App\Http\Controllers\InternalApi;


use Eureka\Helpers\Transformers\Server\RoleCollectionTransformer;
use Eureka\Repositories\RolesRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

/**
 * Class RolesApiController
 * @package App\Http\Controllers\InternalApi
 */
class RolesApiController extends InternalApiController
{
    const RESOURCE_KEY = 'roles';
    /**
     * @var RolesRepository
     */
    private $rolesRepository;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param RolesRepository $rolesRepository
     * @param Manager $fractal
     */
    public function __construct(RolesRepository $rolesRepository, Manager $fractal){
        $this->rolesRepository = $rolesRepository;
        $this->fractal = $fractal->setSerializer(new DataArraySerializer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $roles = $this->rolesRepository->getAll();
        $data = $this->fractal->createData(new Collection($roles,
            new RoleCollectionTransformer))->toArray();
        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function single($id)
    {
        $role = $this->rolesRepository->getSingle($id);
        return $this->fractal->createData(new Item($role,
            new RoleCollectionTransformer))->toArray();
    }

    /**
     * @param $id
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $data)
    {
        $role = $this->rolesRepository->update($id, $data->all());
        return $this->fractal->createData(new Item($role,
            new RoleCollectionTransformer))->toArray();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $role = $this->rolesRepository->create($request->all());
        return $this->fractal->createData(new Item($role,
            new RoleCollectionTransformer))->toArray();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $role = $this->rolesRepository->delete($id);
        return $this->returnResponse($role);
    }

    /**
     * @param $role
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnResponse($role)
    {
        $data = $this->fractal->createData(new Item($role,
            new RoleCollectionTransformer))->toArray();
        return response()->json($data);
    }
}