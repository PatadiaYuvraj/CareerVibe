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
        return view('front.auth.login');
    }

    public function register()
    {
        return view('front.auth.register');
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
                return redirect()->route('dashboard');
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
                    return redirect()->route('dashboard');
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

    public function dashboard()
    {
        return view('front.dashboard');
    }

    public function account()
    {
        return view('front.account');
    }


    public function post_job()
    {
        return view('front.post-job');
    }

    public function job_applied(Request $request)
    {
        return view('front.job-applied');
    }

    public function saved_jobs(Request $request)
    {
        return view('front.saved-jobs');
    }

    public function my_jobs(Request $request)
    {
        return view('front.my-jobs');
    }

    public function job_detail(Request $request)
    {
        return view('front.job-detail');
    }

    public function jobs(Request $request)
    {
        return view('front.jobs');
    }
}
