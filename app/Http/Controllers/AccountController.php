<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    private UserService $user;

    public function __construct(UserService $demo)
    {
        $this->user = $demo;
    }
    public function login()
    {
        return view('front.login');
    }
    public function register()
    {
        return view('front.register');
    }
    public function doLogin(Request $request)
    {
        $validate = $this->user->validateUser($request, false);
        if ($validate->passes()) {

            $data = [
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ];
            $isAuth = $this->user->authenticate($data);
            if ($isAuth['status']) {
                return redirect()->route('index');
            }
            return redirect()->back()->with("msg", "Something went wrong");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }


    public function doRegister(Request $request)
    {
        $validate = $this->user->validateUser($request, true);
        if ($validate->passes()) {
            $data =
                [
                    "name" => $request->get("name"),
                    "email" => $request->get("email"),
                    "password" => $request->get("password")
                ];
            $user = $this->user->createUser($data);
            if ($user['status']) {

                $data =
                    [
                        "email" => $request->get("email"),
                        "password" => $request->get("password")
                    ];
                $isAuth = $this->user->authenticate($data);
                if ($isAuth['status']) {
                    return redirect()->route('index');
                }
                return redirect()->back()->with("msg", "Something went wrong");
            }
            return redirect()->back()->with("msg", "Something went wrong");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route("login")->with("msg", "You're Logged Out");
    }
}
