<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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
                return redirect()->route('index')->with('success', 'You are signed up ');
            }
            return redirect()->back()->with("warning", "Not Authenticated");
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
                    return redirect()->route('index')->with('success', 'You are logged in');
                }
                return redirect()->back()->with("warning", "Something went wrong");
            }
            return redirect()->back()->with("warning", "Something went wrong");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        Session::flush();
        return redirect()->route("login")->with("success", "You're Logged Out");
    }
    public function test()
    {
        dd(Auth::check());
        return view('test');
    }
    public function testing(Request $request)
    {
        // $stored_path = $request->file('profile_image')->store('temp', ['disk' => 'local']);
        // $public_path = asset($stored_path);
        dd(Auth::check());
    }
    public function index()
    {
        return view('front.index');
    }
    // public function about()
    // {
    //     return view('front.about');
    // }
    // public function blog_single()
    // {
    //     return view('front.blog-single');
    // }
    // public function blog()
    // {
    //     return view('front.blog');
    // }
    // public function contact()
    // {
    //     return view('front.contact');
    // }
    // public function faq()
    // {
    //     return view('front.faq');
    // }
    // public function gallery()
    // {
    //     return view('front.gallery');
    // }
    // public function job_listings()
    // {
    //     return view('front.job-listings');
    // }
    // public function job_single()
    // {
    //     return view('front.job-single');
    // }
    // public function portfolio_single()
    // {
    //     return view('front.portfolio-single');
    // }
    // public function portfolio()
    // {
    //     return view('front.portfolio');
    // }
    // public function post_job()
    // {
    //     return view('front.post-job');
    // }
    // public function service_sinlge()
    // {
    //     return view('front.service-sinlge');
    // }
    // public function services()
    // {
    //     return view('front.services');
    // }
    // public function testimonials()
    // {
    //     return view('front.testimonials');
    // }
}
