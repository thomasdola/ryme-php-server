<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 6:49 PM
 */

namespace App\Http\Controllers\AppApi;


use App\Jobs\UpdateBackPicture;
use App\Jobs\UpdateProfileInfo;
use App\Jobs\UpdateProfilePicture;
use Dingo\Api\Http\Request;
use Eureka\Helpers\Transformers\Mobile\MobileTrackCollectionTransformer;
use Eureka\Helpers\Transformers\Mobile\UserItemTransformer;
use Eureka\Repositories\UserRepository;
use Eureka\Services\Interfaces\VouchServiceInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UsersController extends PublicApiController
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param UserRepository $repository
     * @param Manager $fractal
     */
    public function __construct(UserRepository $repository, Manager $fractal){
        $this->repository = $repository;
        $this->fractal = $fractal;
    }

    public function favorites(Request $request)
    {
        if(!$request->has('type')){
            return $this->respondForDataMerge("error", 400, "missing type of favorites");
        }
        $type = $request->get('type');
        $favorites = $this->getFavorites($type);
        return $this->respondForDataMerge("success", 200, "here are your data", $favorites);
    }

    public function update(Request $request)
    {
        $job = new UpdateProfileInfo($request->all(), $this->auth->user());
        try{
            $this->dispatch($job);
            return $this->respondForAction("success", 200, "information updated successfully.");
        }catch (\Exception $e){
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    public function isAllowedToBeArtist(VouchServiceInterface $vouchService){

        $isHe = $vouchService->isAllowed($this->auth->user());
        if(!$isHe){
            return $this->respondForAction("error", 401, "Not Allowed");
        }
        return $this->respondForAction("success", 200, "Allowed");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws FileException
     * @throws \Exception
     */
    public function photo(Request $request){
        $user = $this->auth->user();
        $file = $request->file;
        if($file->isValid()){
            $type = $request->type;
            if(strtolower($type) == "avatar"){
                return $this->launchAvatarSaver($file, $user, $type);
            }elseif(strtolower($request->type) == "background"){
                return $this->launchBackImageSaver($file, $user, $type);
            }
        }else{
            return $this->respondForAction("error", 404, "file not found");
        }
    }

    public function upload(Request $request){}

    public function followedCategories(){
        $categories = $this->repository->followedCategories($this->auth->user());
        return $this->response->array($categories)->setStatusCode(200);
    }

    /**
     * @param $type
     * @return mixed
     */
    private function getFavorites($type)
    {
        $user = $this->auth->user();
        if ($type == 'tracks') {
            $favorites = $this->repository->getFavoriteTracksFor($user);
            $favorites = $this->fractal->createData(new
            Collection($favorites, new MobileTrackCollectionTransformer($this->auth->user())))
                ->toArray();
            return $favorites;
        } elseif ($type == 'artists') {
            $favorites = $this->repository->getFavoriteArtistsFor($user);
            $favorites = $this->fractal->createData(new Collection($favorites, new UserItemTransformer()))
                ->toArray();
            return $favorites;
        }
        return null;
    }

    /**
     * @param $file
     * @param $user
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    private function launchAvatarSaver($file, $user, $type)
    {
        $data = $this->moveFile($file, $user, $type);
        $job = new UpdateProfilePicture($data, $user);
        try {
            $this->dispatch($job);
            return $this->respondForAction("error", 200, "image saved successfully.");
        } catch (\Exception $e) {
//            return $this->respondForAction("error", $e->getCode());
            throw $e;
        }
    }

    /**
     * @param $file
     * @param $user
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    private function launchBackImageSaver($file, $user, $type)
    {
        $data = $this->moveFile($file, $user, $type);
        $job = new UpdateBackPicture($data, $user);
        try{
            $this->dispatch($job);
            return $this->respondForAction("error", 200, "image saved successfully.");
        } catch (\Exception $e) {
            return $this->respondForAction("error", $e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param $file
     * @param $user
     * @param $type
     * @return array
     */
    private function moveFile($file, $user, $type)
    {
        $data = [];
        $destinationPath = base_path() . '/public/users/profile/images/';
        $ext = $file->getClientOriginalExtension();
        $fileName = $user->username . '_' . $type . '_' . '.' . $ext;
        $full_path = '/users/profile/images/' . $fileName;
        $data = array_add(array_add($data, "path", $full_path), "extension", $ext);
        try {
            $file->move($destinationPath, $fileName);
            return $data;
        } catch (FileException $e) {
            throw $e;
        }
        return $data;
    }
}