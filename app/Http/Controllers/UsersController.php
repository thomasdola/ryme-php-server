<?php

namespace App\Http\Controllers;

use Eureka\Repositories\UserRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersJoinedToday = $this->userRepository->getUsersJoinedTodayCount();
        $usersJoinedThisWeek = $this->userRepository->getUsersJoinedThisWeekCount();
        $usersJoinedThisMonth = $this->userRepository->getUsersJoinedThisMonthCount();
        $allUsers = $this->userRepository->getAllUsersCount();
        return view('users.index', [
            'joinedToday' => $usersJoinedToday,
            'joinedThisWeek' => $usersJoinedThisWeek,
            'joinedThisMonth' => $usersJoinedThisMonth,
            'total' => $allUsers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProfile()
    {
       return view('users.profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userRepository->deleteUserById($id);
    }

    public function searchUserByName(Request $request){}
}
