<?php

namespace App\Http\Controllers\InternalApi;

use Eureka\Helpers\Transformers\Server\UserCollectionTransformer;
use Eureka\Repositories\UserRepository;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class UsersApiController extends InternalApiController
{
    /**
     * @var Manager
     */
    private $fractal;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(Manager $fractal, UserRepository $userRepository){
        $this->fractal = $fractal->setSerializer(new JsonApiSerializer(self::BASE_URL));
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        $users = $this->userRepository->getUsersJoinedToday();
        return $this->fractal->createData(new Collection($users,
            new UserCollectionTransformer, 'users'))->toArray();
    }

    public function single(){}

    public function update(){}

    public function delete(){}

    public function indexPageData()
    {
        $todayCount = $this->userRepository->getUsersJoinedTodayCount();
        $thisWeekCount = $this->userRepository->getUsersJoinedThisWeekCount();
        $thisMonthCount = $this->userRepository->getUsersJoinedThisMonthCount();
        $allCount = $this->userRepository->getAllUsersCount();
        return response()->json([
            [
                'title' => 'Users Joined Today',
                'total' => $todayCount
            ],
            [
                'title' => 'Users Joined This Week',
                'total' => $thisWeekCount
            ],
            [
                'title' => 'Users Joined This Month',
                'total' => $thisMonthCount
            ],
            [
                'title' => 'All Users',
                'total' => $allCount
            ]
        ]);
    }

    public function totalUsers()
    {
        $allUsersCount = $this->userRepository->getAllUsersCount();
        return response()->json([
            'title' => 'users',
            'total' => $allUsersCount
        ])->setStatusCode(200);
    }
}