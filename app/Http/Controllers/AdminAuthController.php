<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $this->getCredentials($request);
        $attempt = Auth::attempt($credentials);

        if( !$attempt){
            session()->flash('error', 'Invalid Email/Password');
            return redirect()->back()->withInput();
        }
        return redirect()->intended('/admin/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('getLogin');
    }

    /**
     * @param Request $request
     * @return static
     */
    private function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }
}
