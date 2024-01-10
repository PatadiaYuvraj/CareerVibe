<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private AdminService $admin;

    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
    }
    public function dashboard()
    {
        return view('admin.index');
    }
    public function login()
    {
        return view('admin.login');
    }
    public function register()
    {
        return view('admin.register');
    }
    public function doLogin(Request $request)
    {
        $validate = $this->admin->validateAdmin($request, false);
        if ($validate->passes()) {

            $data = [
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ];
            $isAuth = $this->admin->authenticate($data);
            if ($isAuth['status']) {
                return redirect()->route('admin.index');
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
        $validate = $this->admin->validateAdmin($request, true);
        if ($validate->passes()) {
            $data =
                [
                    "name" => $request->get("name"),
                    "email" => $request->get("email"),
                    "password" => $request->get("password")
                ];
            $admin = $this->admin->createAdmin($data);
            if ($admin['status']) {

                $data =
                    [
                        "email" => $request->get("email"),
                        "password" => $request->get("password")
                    ];
                $isAuth = $this->admin->authenticate($data);
                if ($isAuth['status']) {
                    return redirect()->route('admin.index');
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
        return redirect()->route("admin.login")->with("msg", "You're Logged Out");
    }
}
