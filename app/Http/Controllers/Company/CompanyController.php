<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFromCloudinary;
use App\Models\Company;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    private string $folder = 'career-vibe/companies/profile_image';

    private Company $company;
    private $current_company;

    public function __construct(Company $company)
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (auth()->guard('company')->check()) {
                $this->current_company = auth()->guard('company')->user();
            }
            return $next($request);
        });
        $this->company = $company;
    }

    public function login()
    {
        // dd(auth()->guard('company')->check());
        return view('company.auth.login');
    }

    public function register()
    {
        return view('company.auth.register');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $company = Company::where("email", $value)->first();
                    if (!$company) {
                        $fail("Email does not exist");
                    }
                }
            ],
            "password" => [
                "required",
                "min:8",
                "max:20",
                function ($attribute, $value, $fail) use ($request) {
                    $company = Company::where("email", $request->get("email"))->first();
                    if ($company && !Hash::check($value, $company->password)) {
                        $fail("Invalid Credentials");
                    }
                }
            ]
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];
        if (auth()->guard('company')->attempt($data, true)) {
            auth()->login(auth()->guard('company')->user(), true);
            return redirect()->route('company.dashboard')->with("success", "You're Logged In");
        }
        return redirect()->back()->with("warning", "Invalid Credentials");
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            "name" => [
                "required",
                "min:3",
                "max:50",
            ],
            "email" => [
                "required",
                "email",
                "unique:companies,email"
            ],
            "password" => [
                "required",
                "min:8",
                "max:20",
            ],
            "confirm_password" => [
                "required",
                "same:password"
            ]
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => Hash::make($request->get("password"))
        ];

        $isCreated = $this->company->create($data);

        if ($isCreated) {
            $isAuth = auth()->guard('company')->attempt([
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ]);

            if ($isAuth) {
                return redirect()->route('company.dashboard')->with("success", "You're Logged In");
            }
            return redirect()->back()->with("warning", "Invalid Credentials");
        }
        return redirect()->back()->with("warning", "Something went wrong");
    }

    public function logout()
    {
        auth()->guard('company')->logout();
        session()->flush();
        return redirect()->route('company.login')->with("success", "You're Logged Out");
    }

    public function dashboard()
    {
        return view('company.dashboard.index');
    }

    public function changePassword()
    {
        return view('company.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {

        // currentPassword newPassword confirmPassword

        if (!auth()->guard('company')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = $this->current_company->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->find($id);
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
                    $user = $this->company->find($id);
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

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('company.dashboard')->with("success", "Password Updated Successfully");
        }

        return redirect()->back()->with("warning", "Password Not Updated");
    }

    public function editProfile()
    {
        return view('company.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $id = $this->current_company->id;

        $request->validate([
            "name" => "required|min:3|max:50",
            "email" => "required|email|unique:companies,email," . $id
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email")
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('company.dashboard')->with("success", "Profile Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Not Updated");
    }

    public function updateProfileImage(Request $request)
    {
        $id = $this->current_company->id;

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->company->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);
        }

        // delete local file after uploading to cloudinary

        $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
        $obj = (new UploadApi())->upload(
            $stored_path,
            [
                'folder' => $this->folder,
                'resource_type' => 'image'
            ]
        );

        Storage::delete($stored_path);


        $data = [
            "profile_image_public_id" => $obj['public_id'],
            "profile_image_url" => $obj['secure_url'],
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);
        if ($isUpdated) {


            return redirect()->route('company.dashboard')->with("success", "Profile Image Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Updated");
    }

    public function deleteProfileImage()
    {
        $id = $this->current_company->id;

        $user = $this->company->find($id);

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

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('company.dashboard')->with("success", "Profile Image Deleted Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Deleted");
    }
}
