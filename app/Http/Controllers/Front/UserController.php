<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('front.index');
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
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'min:3',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    if (!$user) {
                        return $fail('Email does not exist');
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ]
        ]);
        $data =
            [
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ];
        $isAuth = Auth::guard('user')->attempt($data, true);
        if ($isAuth) {
            return redirect()->route('index')->with('success', 'You are logged in');
        }
        return redirect()->back()->with("warning", "Something went wrong");
    }


    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'min:3',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    if ($user) {
                        return $fail('Email already exist');
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8',
                'same:password',
            ]
        ]);
        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];

        $user = $this->user->create($data);
        if ($user) {
            $data =
                [
                    "email" => $request->get("email"),
                    "password" => $request->get("password")
                ];
            $isAuth = Auth::guard('user')->attempt($data, true);
            if ($isAuth) {

                return redirect()->route('index')->with('success', 'You are logged in');
            }
            return redirect()->route('login')->with('success', 'You are registered');
        }
        return redirect()->back()->with("warning", "Something went wrong");
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        Session::flush();
        return redirect()->route("login")->with("success", "You're Logged Out");
    }

    public function about()
    {
        return view('front.about');
    }
    public function blog_single()
    {
        return view('front.blog-single');
    }
    public function blog()
    {
        return view('front.blog');
    }
    public function contact()
    {
        return view('front.contact');
    }
    public function faq()
    {
        return view('front.faq');
    }
    public function gallery()
    {
        return view('front.gallery');
    }
    public function job_listings()
    {
        return view('front.job-listings');
    }
    public function job_single()
    {
        return view('front.job-single');
    }
    public function portfolio_single()
    {
        return view('front.portfolio-single');
    }
    public function portfolio()
    {
        return view('front.portfolio');
    }
    public function post_job()
    {
        return view('front.post-job');
    }
    public function service_sinlge()
    {
        return view('front.service-sinlge');
    }
    public function services()
    {
        return view('front.services');
    }
    public function testimonials()
    {
        return view('front.testimonials');
    }
}
