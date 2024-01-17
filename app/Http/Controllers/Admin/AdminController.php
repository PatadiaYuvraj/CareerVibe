<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFromCloudinary;
use App\Jobs\UploadToCloudinary;
use App\Models\Admin;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private Admin $admin;
    private string $user_type = 'admin';
    private string $folder = 'career-vibe/admins/profile_image';

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:6|max:20"
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];

        if (Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin.dashboard')->with("success", "You're Logged In");
        }
        return redirect()->back()->with("warning", "Invalid Credentials");
    }

    public function register()
    {
        return view('admin.auth.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:50",
            "email" => "required|email|unique:admins,email",
            "password" => "required|min:6|max:20",
            "confirm_password" => "required|min:6|max:20|same:password"
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => Hash::make($request->get("password"))
        ];

        $isCreated = $this->admin->create($data);

        if ($isCreated) {
            $isAuth = Auth::guard('admin')->attempt([
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ]);

            if ($isAuth) {
                return redirect()->route('admin.dashboard')->with("success", "You're Logged In");
            }

            return redirect()->route('admin.login')->with("success", "Admin Created Successfully");
        }

        return redirect()->back()->with("warning", "Admin Not Created");
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect()->route('admin.login')->with("success", "You're Logged Out");
    }

    public function changePassword()
    {
        return view('admin.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {

        // currentPassword newPassword confirmPassword

        if (!Auth::guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = Auth::guard('admin')->user()->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->admin->find($id);
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }

            ],
            "newPassword" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->admin->find($id);
                    if (Hash::check($value, $user->password)) {
                        return $fail(__('The new password must be different from current password.'));
                    }
                }
            ],
            "confirmPassword" => [
                "required",
                "min:6",
                "max:20",
                "same:newPassword"
            ]
        ]);

        $data = [
            "password" => Hash::make($request->get("newPassword"))
        ];

        $isUpdated = $this->admin->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('admin.dashboard')->with("success", "Password Updated Successfully");
        }

        return redirect()->back()->with("warning", "Password Not Updated");
    }

    public function editProfile()
    {
        return view('admin.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = Auth::guard('admin')->user()->id;

        $request->validate([
            "name" => "required|min:3|max:50",
            "email" => "required|email|unique:admins,email," . $id
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email")
        ];

        $isUpdated = $this->admin->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('admin.dashboard')->with("success", "Profile Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Not Updated");
    }

    public function updateProfileImage(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = Auth::guard('admin')->user()->id;

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->admin->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);
        }



        UploadToCloudinary::dispatch(
            $request->file('profile_image_url'),
            $this->folder,
            $id,
            $this->user_type
        );

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];
        $isUpdated = $this->admin->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('admin.dashboard')->with("success", "Profile Image Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Updated");
    }

    public function deleteProfileImage()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = Auth::guard('admin')->user()->id;

        $user = $this->admin->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);
        }

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->admin->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('admin.dashboard')->with("success", "Profile Image Deleted Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Deleted");
    }

    // forget password

    // public function forgetPassword()
    // {
    //     return view('admin.auth.forget-password');
    // }

    // public function doForgetPassword(Request $request)
    // {
    //     $request->validate([
    //         "email" => "required|email"
    //     ]);

    //     $user = $this->admin->where('email', $request->get('email'))->first();

    //     if (!$user) {
    //         return redirect()->back()->with("warning", "User is not found");
    //     }

    //     $token = $this->admin->generateToken();

    //     $data = [
    //         "token" => $token
    //     ];

    //     $isUpdated = $this->admin->where('id', $user->id)->update($data);

    //     if ($isUpdated) {
    //         $user->sendPasswordResetNotification($token);
    //         return redirect()->route('admin.login')->with("success", "Password Reset Link Sent Successfully");
    //     }

    //     return redirect()->back()->with("warning", "Password Reset Link Not Sent");
    // }

    // public function resetPassword($token)
    // {
    //     $user = $this->admin->where('token', $token)->first();

    //     if (!$user) {
    //         return redirect()->route('admin.login')->with("warning", "Invalid Token");
    //     }

    //     return view('admin.auth.reset-password', compact('token'));
    // }

    // public function doResetPassword(Request $request, $token)
    // {
    //     $request->validate([
    //         "password" => "required|min:6|max:20",
    //         "confirm_password" => "required|min:6|max:20|same:password"
    //     ]);

    //     $user = $this->admin->where('token', $token)->first();

    //     if (!$user) {
    //         return redirect()->route('admin.login')->with("warning", "Invalid Token");
    //     }

    //     $data = [
    //         "password" => Hash::make($request->get("password")),
    //         "token" => null
    //     ];

    //     $isUpdated = $this->admin->where('id', $user->id)->update($data);

    //     if ($isUpdated) {
    //         return redirect()->route('admin.login')->with("success", "Password Reset Successfully");
    //     }

    //     return redirect()->back()->with("warning", "Password Not Reset");
    // }


}
