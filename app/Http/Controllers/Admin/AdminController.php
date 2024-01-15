<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private AdminService $admin;

    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
    }

    public function dashboard()
    {
        return view('admin.dashboard.index');
        // $admin_id = Auth::guard('admin')->user()->id;
        // $admin = Admin::select('id', 'name')->find($admin_id)->toArray();
        // return view('admin.dashboard.index', compact('admin'));
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function register()
    {
        return view('admin.auth.register');
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

    public function changePassword()
    {
        return view('admin.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {
        $auth = new AuthService();
        if (!$auth->isAdmin()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }
        $admin_id = Auth::guard('admin')->user()->id;

        $validate = $this->admin->validatePassword($request);
        if ($validate->passes()) {
            $data = [
                "currentPassword" => $request->get("currentPassword"),
                "newPassword" => $request->get("newPassword"),
                "confirmPassword" => $request->get("confirmPassword")
            ];
            $isChanged = $this->admin->changePassword($data, $admin_id);
            if ($isChanged['status']) {
                return redirect()->route('admin.dashboard')->with("success", $isChanged['msg']);
            }
            return redirect()->back()->with("warning", $isChanged['msg']);
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function editProfile()
    {
        return view('admin.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $auth = new AuthService();
        if (!$auth->isAdmin()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }
        $admin_id = Auth::guard('admin')->user()->id;
        $validate = Validator::make($request->all(), [
            "name" => "required|min:3|max:50",
            "email" => "required|email|unique:users,email," . $admin_id,
        ]);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
            ];
            $isUpdated = $this->admin->updateAdmin($data, $admin_id);
            if ($isUpdated['status']) {
                return redirect()->route('admin.dashboard')->with("success", $isUpdated['msg']);
            }
            return redirect()->back()->with("warning", $isUpdated['msg']);
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }
}
