<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFromCloudinary;
use App\Models\Admin;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private Admin $admin;
    private string $user_type = 'admin';
    private string $folder = 'career-vibe/admins/profile_image';
    private int $paginate;
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->paginate = env('PAGINATEVALUE');
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
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $user = $this->admin->where('email', $value)->first();
                    if (!$user) {
                        return $fail(__('The email is not registered.'));
                    }
                }
            ],
            "password" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) {
                    $user = $this->admin->where('email', request()->get('email'))->first();
                    if ($user && !Hash::check($value, $user->password)) {
                        return $fail(__('The password is incorrect.'));
                    }
                }
            ]
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];

        if (auth()->guard($this->user_type)->attempt($data, true)) {
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
            "name" => [
                "required",
                "string",
                "max:100",
                function ($attribute, $value, $fail) {
                    $isExist = $this->admin->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $isExist = $this->admin->where('email', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "password" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) {
                    $name = $this->admin->where('name', request()->get('name'))->first();
                    $email = $this->admin->where('email', request()->get('email'))->first();
                    if ($name && Hash::check($value, $name->password)) {
                        return $fail(__('The password should not be same as name.'));
                    }
                    if ($email && Hash::check($value, $email->password)) {
                        return $fail(__('The password should not be same as email.'));
                    }
                }
            ],
            "confirm_password" => "required|min:6|max:20|same:password"
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => Hash::make($request->get("password"))
        ];

        $isCreated = $this->admin->create($data);

        if ($isCreated) {
            $isAuth = auth()->guard('admin')->attempt([
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
        auth()->guard('admin')->logout();
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

        if (!auth()->guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('admin')->user()->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->admin->find($id);
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                },
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->admin->find($id);
                    if (Hash::check($value, $user->password)) {
                        return $fail(__('The new password must be different from current password.'));
                    }
                },
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
        if (!auth()->guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('admin')->user()->id;

        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->admin->where('id', '!=', $id)->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->admin->where('id', '!=', $id)->where('email', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ]
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

    public function editProfileImage()
    {
        return view('admin.auth.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('admin')->user()->id;

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


        $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
        $obj = (new UploadApi())->upload(
            $stored_path,
            [
                'folder' => $this->folder,
                'resource_type' => 'image'
            ]
        );



        $data = [
            "profile_image_public_id" => $obj['public_id'],
            "profile_image_url" => $obj['secure_url'],
        ];

        $isUpdated = $this->admin->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('admin.dashboard')->with("success", "Profile Image Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Updated");
    }

    public function deleteProfileImage()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('admin')->user()->id;

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
    //         "email" => [
    //             "required",
    //             "email",
    //       function ($attribute, $value, $fail) {
    //         $user = $this->admin->where('email', $value)->first();
    //         if (!$user) {
    //             return $fail(__('The email is not registered.'));
    //         }
    //      }
    //      ]
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
