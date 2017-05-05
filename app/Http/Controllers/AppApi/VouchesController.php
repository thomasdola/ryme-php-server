<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 6:49 PM
 */

namespace App\Http\Controllers\AppApi;


use App\Jobs\AnswerVouch;
use App\Jobs\MakeVouchRequest;
use Dingo\Api\Http\Request;
use Eureka\Repositories\CategoryRepository;
use Eureka\Repositories\VouchRepository;

/**
 * Class VouchesController
 * @package App\Http\Controllers\AppApi
 */
class VouchesController extends PublicApiController
{
    /**
     * @var VouchRepository
     */
    private $repository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param VouchRepository $repository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(VouchRepository $repository, CategoryRepository $categoryRepository){
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeRequest(Request $request)
    {
        $payload = $request->only('stage_name');
        $user_gcm_reg_token = $request->get('token');
        $category_id = $this->categoryRepository->getCategoryIdByName($request->category);
        $payload = array_add($payload, "category_id", $category_id);
        try{
            $this->dispatch(new MakeVouchRequest($payload, $this->auth->user(), $user_gcm_reg_token));
            return $this->respondForAction("success", 200, "Request was made successfully.");
        }catch (\Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    public function answer($vouchId, Request $request)
    {
        $vouch = $this->repository->getVouch($vouchId);
        $user_gcm_reg_token = $request->get('token');
        $answer = $request->get('answer');
        try{
            $this->dispatch(new AnswerVouch($vouch, $answer, $this->auth->user(), $user_gcm_reg_token));
            $this->respondForAction("success", 200, "Answer was successful.");
        }catch (\Exception $e){
            $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }
}