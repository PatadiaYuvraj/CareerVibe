<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\DeleteFromCloudinary;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /*
    Route::prefix('/user')->group(function () {
        Route::get('/login',  [UserUserController::class, "login"])->name('user.login');
        Route::get('/register', [UserUserController::class, "register"])->name('user.register');
        Route::post('/login', [UserUserController::class, "doLogin"])->name('user.doLogin');
        Route::post('/register', [UserUserController::class, "doRegister"])->name('user.doRegister');
    });
    Route::group(['middleware' => "isUser"], function () {
        Route::get('/edit-profile',  [UserUserController::class, "editProfile"])->name('user.editProfile');
        Route::post('/update-profile',  [UserUserController::class, "updateProfile"])->name('user.updateProfile');
        Route::get('/change-password',  [UserUserController::class, "changePassword"])->name('user.changePassword');
        Route::post('/change-password',  [UserUserController::class, "doChangePassword"])->name('user.doChangePassword');
        Route::get('/edit-profile-image',  [UserUserController::class, "editProfileImage"])->name('user.editProfileImage');
        Route::post('/update-profile-image',  [UserUserController::class, "updateProfileImage"])->name('user.updateProfileImage');
        Route::post('/delete-profile-image',  [UserUserController::class, "deleteProfileImage"])->name('user.deleteProfileImage');
        Route::get('/edit-resume-pdf',  [UserUserController::class, "editResumePdf"])->name('user.editResumePdf');
        Route::post('/update-resume-pdf',  [UserUserController::class, "updateResumePdf"])->name('user.updateResumePdf');
        Route::get('/delete-resume-pdf',  [UserUserController::class, "deleteResumePdf"])->name('user.deleteResumePdf');
        Route::get('/dashboard',  [UserUserController::class, "dashboard"])->name('user.dashboard');
        Route::get('/logout',  [UserUserController::class, "logout"])->name('user.logout');
        });
    });
    */

    private User $user;
    private string $user_type = 'user';
    private string $folder = 'career-vibe/users/profile_image';
    private int $paginate;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->paginate = env('PAGINATEVALUE');
    }

    public function dashboard()
    {
        return view('user.dashboard.index');
    }

    public function login()
    {
        return view('user.auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $user = $this->user->where('email', $value)->first();
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
                    $user = $this->user->where('email', request()->get('email'))->first();
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
            return redirect()->route('user.dashboard')->with("success", "You're Logged In");
        }
        return redirect()->back()->with("warning", "Invalid Credentials");
    }

    public function register()
    {
        return view('user.auth.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                function ($attribute, $value, $fail) {
                    $isExist = $this->user->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $isExist = $this->user->where('email', $value)->get()->ToArray();
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
                    $name = $this->user->where('name', request()->get('name'))->first();
                    $email = $this->user->where('email', request()->get('email'))->first();
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

        $isCreated = $this->user->create($data);

        if ($isCreated) {
            $isAuth = auth()->guard('user')->attempt([
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ]);

            if ($isAuth) {
                return redirect()->route('user.dashboard')->with("success", "You're Logged In");
            }

            return redirect()->route('user.login')->with("success", "User Created Successfully");
        }

        return redirect()->back()->with("warning", "User Not Created");
    }

    public function logout()
    {
        auth()->guard('user')->logout();
        Session::flush();
        return redirect()->route('user.login')->with("success", "You're Logged Out");
    }

    public function changePassword()
    {
        return view('user.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->user->find($id);
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                },
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->user->find($id);
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
                    $user = $this->user->find($id);
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

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('user.dashboard')->with("success", "Password Updated Successfully");
        }

        return redirect()->back()->with("warning", "Password Not Updated");
    }

    public function editProfile()
    {
        return view('user.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->user->where('id', '!=', $id)->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->user->where('id', '!=', $id)->where('email', $value)->get()->ToArray();
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

        $data['contact'] =  $data['city'] = $data['headline'] = $data['gender'] = $data['education'] = $data['interest'] = $data['hobby'] = $data['about'] = $data['experience'] = null;
        if ($request->contact) {
            $request->validate([
                "contact" => [
                    "required",
                    "string",
                    "max:15",
                ],
            ]);
            $data["contact"] = $request->contact;
        }

        if ($request->city) {
            $request->validate([
                "city" => [
                    "required",
                    "string",
                    "max:30",
                ],
            ]);
            $data["city"] = $request->city;
        }

        if ($request->headline) {
            $request->validate([
                "headline" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["headline"] = $request->headline;
        }

        if ($request->get('gender')) {
            $request->validate([
                'gender' => [
                    'required',
                    'string',
                    'max:10',
                    'in:MALE,FEMALE,OTHER'
                ],
            ]);
            $data['gender'] = $request->gender;
        }


        if ($request->education) {
            $request->validate([
                "education" => [
                    "required",
                    "string",
                    "max:200",
                ],
            ]);
            $data["education"] = $request->education;
        }

        if ($request->interest) {
            $request->validate([
                "interest" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["interest"] = $request->interest;
        }

        if ($request->hobby) {
            $request->validate([
                "hobby" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["hobby"] = $request->hobby;
        }

        if ($request->about) {
            $request->validate([
                "about" => [
                    "required",
                    "string",
                    "max:500",
                ],
            ]);
            $data["about"] = $request->about;
        }

        if ($request->experience) {
            $request->validate([
                "experience" => [
                    "required",
                    "string",
                    "max:200",
                ],
            ]);
            $data["experience"] = $request->experience;
        }

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('user.dashboard')->with("success", "Profile Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Not Updated");
    }

    public function editProfileImage()
    {
        return view('user.auth.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->user->find($id);

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

        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('user.dashboard')->with("success", "Profile Image Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Updated");
    }

    public function deleteProfileImage()
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $user = $this->user->find($id);

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

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('user.dashboard')->with("success", "Profile Image Deleted Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Deleted");
    }

    public function editResumePdf()
    {
        return view('user.auth.edit-resume-pdf');
    }

    public function updateResumePdf(Request $request)
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "resume_pdf_url" => [
                "required",
                "mimes:pdf",
                "max:2048",
            ],
        ]);
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        if ($user->resume_pdf_url) {
            Storage::delete($user->resume_pdf_url);
        }
        $stored_path = Storage::putFile('temp', $request->file('resume_pdf_url'));
        $data = [
            "resume_pdf_url" => $stored_path,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('user.dashboard')->with("success", "User resume is updated");
        }
        return redirect()->back()->with("warning", "User resume is not updated");
    }

    public function deleteResumePdf()
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $user = $this->user->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->resume_pdf_url) {
            unlink($user->resume_pdf_url);
        }

        $data = [
            "resume_pdf_public_id" => null,
            "resume_pdf_url" => null,
        ];

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('user.dashboard')->with("success", "Resume Pdf Deleted Successfully");
        }

        return redirect()->back()->with("warning", "Resume Pdf Not Deleted");
    }
}
