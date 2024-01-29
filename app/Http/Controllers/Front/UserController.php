<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;


class UserController extends Controller
{

    private AuthenticableService $authenticableService;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        AuthenticableService $authenticableService,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->authenticableService = $authenticableService;
        $this->navigationManagerService = $navigationManagerService;
    }

    public function index()
    {
        return $this->navigationManagerService->loadView('front.index');
    }

    public function login()
    {
        return $this->navigationManagerService->loadView('front.login');
    }
    public function register()
    {
        return $this->navigationManagerService->loadView('front.register');
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
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];
        $isAuth = $this->authenticableService->loginUser($data);
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

        $user = $this->authenticableService->registerUser($data);
        if ($user) {
            $isAuth = $this->authenticableService->loginUser($data);
            if ($isAuth) {
                return $this->navigationManagerService->redirectRoute('index', [], 302, [], false, ["success" => "You are Logged In"]);
            }
            return $this->navigationManagerService->redirectRoute('login', [], 302, [], false, ["success" => "You are registered"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Something went wrong"]);
    }

    public function logout()
    {
        $this->authenticableService->logoutUser();
        return $this->navigationManagerService->redirectRoute('login', [], 302, [], false, ["success" => "You are Logged Out"]);
    }
}
