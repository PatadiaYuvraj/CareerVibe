<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Job;
use App\Models\Location;
use App\Models\Qualification;
use App\Models\User;
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
        $admin_id = Auth::guard('admin')->user()->id;
        $admin = Admin::find($admin_id)?->toArray();
        return view('admin.index', compact('admin'));
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
                return redirect()->route('admin.dashboard')->with("success", "You're Logged In");
            }
            return redirect()->back()->with("warning", "Something went wrong");
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
                    return redirect()->route('admin.dashboard')->with("success", "You're Logged In");
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
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect()->route("admin.login")->with("msg", "You're Logged Out");
    }
}
