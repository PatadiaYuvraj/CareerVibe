<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFromCloudinary;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:100'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:100', 'same:password'],
        ]);
        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ];

        if ($request->file('profile_image_url')) {
            $request->validate([
                "profile_image_url" => ["required", "image", "mimes:jpeg,png,jpg", "max:2048"],
            ]);
            $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
            $obj = (new UploadApi())->upload(
                $stored_path,
                [
                    'folder' => 'career-vibe/users/profile_image',
                    'resource_type' => 'image'
                ]
            );
            $data["profile_image_public_id"] = $obj['public_id'];
            $data["profile_image_url"] = $obj['secure_url'];
            unlink($stored_path);
        }

        if ($request->file('resume_pdf_url')) {
            $request->validate([
                "resume_pdf_url" => ["required", "mimes:pdf", "max:2048",],
            ]);
            $stored_path = Storage::putFile('temp', $request->file('resume_pdf_url'));
            $data["resume_pdf_url"] = $stored_path;
            $data["resume_pdf_public_id"] = null;
        }

        if ($request->contact) {
            $request->validate([
                "contact" => ["required", "string", "max:15",],
            ]);
            $data["contact"] = $request->contact;
        }

        if ($request->city) {
            $request->validate([
                "city" => ["required", "string", "max:30",],
            ]);
            $data["city"] = $request->city;
        }

        if ($request->headline) {
            $request->validate([
                "headline" => ["required", "string", "max:100",],
            ]);
            $data["headline"] = $request->headline;
        }

        if ($request->gender) {
            $request->validate([
                'gender' => ['required', 'string', 'max:10', 'in:MALE,FEMALE,OTHER'],
            ]);
            $data['gender'] = $request->gender;
        }

        if ($request->education) {
            $request->validate([
                "education" => ["required", "string", "max:200",],
            ]);
            $data["education"] = $request->education;
        }

        if ($request->interest) {
            $request->validate([
                "interest" => ["required", "string", "max:100",],
            ]);
            $data["interest"] = $request->interest;
        }

        if ($request->hobby) {
            $request->validate([
                "hobby" => ["required", "string", "max:100",],
            ]);
            $data["hobby"] = $request->hobby;
        }

        if ($request->about) {
            $request->validate([
                "about" => ["required", "string", "max:500",],
            ]);
            $data["about"] = $request->about;
        }

        if ($request->experience) {
            $request->validate([
                "experience" => ["required", "string", "max:200",],
            ]);
            $data["experience"] = $request->experience;
        }

        $isCreated = $this->user->create($data);
        if ($isCreated) {
            return redirect()->route('admin.user.index')->with("success", "User is created");
        }
        return redirect()->back()->with("warning", "User is not created");
    }

    public function index()
    {
        $users = $this->user->paginate(5);
        return view('admin.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = $this->user->where('id', $id)->get()->ToArray();
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        $user  =  $user[0];
        dd($user);
        return view('admin.user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->user->where('id', $id)->get()->ToArray();
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        $user  =  $user[0];
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email,' . $id],
        ]);
        $data = [
            "name" => $request->name,
            "email" => $request->email,
        ];

        // if profile_image_url is already exist then delete it from cloudinary
        if ($request->file('profile_image_url')) {
            $request->validate([
                "profile_image_url" => [
                    "required",
                    "image",
                    "mimes:jpeg,png,jpg",
                    "max:2048",
                ],
            ]);

            if ($user->profile_image_url) {
                $public_ids = $user->profile_image_public_id;
                DeleteFromCloudinary::dispatch($public_ids);
            }

            $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
            $obj = (new UploadApi())->upload(
                $stored_path,
                [
                    'folder' => 'career-vibe/users/profile_image',
                    'resource_type' => 'image'
                ]
            );
            $data["profile_image_public_id"] = $obj['public_id'];
            $data["profile_image_url"] = $obj['secure_url'];
            unlink($stored_path);
        }

        if ($request->file('resume_pdf_url')) {
            $request->validate([
                "resume_pdf_url" => [
                    "required",
                    "mimes:pdf",
                    "max:2048",
                ],
            ]);

            if ($user->resume_pdf_url) {
                Storage::delete($user->resume_pdf_url);
            }

            $stored_path = Storage::putFile('temp', $request->file('resume_pdf_url'));
            $data["resume_pdf_url"] = $stored_path;
            $data["resume_pdf_public_id"] = null;
        }

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
            return redirect()->route('admin.user.index')->with("success", "User is updated");
        }
        return redirect()->back()->with("warning", "User is not updated");
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);
        }
        if ($user->resume_pdf_url) {
            Storage::delete($user->resume_pdf_url);
        }
        $isDeleted = $this->user->where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.user.index')->with("success", "User is deleted");
        }
        return redirect()->back()->with("warning", "User is not deleted");
    }

    public function passwordReset($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        return view('admin.user.password-reset', compact('user'));
    }

    public function updateUserPassword(Request $request, $id)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8', 'max:100'],
            'new_password' => ['required', 'string', 'min:8', 'max:100'],
            'confirm_password' => ['required', 'string', 'min:8', 'max:100', 'same:new_password'],
        ]);
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with("warning", "Old password is not matched");
        }

        $data = [
            "password" => Hash::make($request->new_password),
        ];

        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('admin.user.index')->with("success", "User password is updated");
        }
        return redirect()->back()->with("warning", "User password is not updated");
    }

    public function updateUserProfileImage(Request $request, $id)
    {
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
                'folder' => 'career-vibe/users/profile_image',
                'resource_type' => 'image'
            ]
        );
        $data = [
            "profile_image_public_id" => $obj['public_id'],
            "profile_image_url" => $obj['secure_url'],
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            unlink($stored_path);
            return redirect()->route('admin.user.index')->with("success", "User profile image is updated");
        }
        return redirect()->back()->with("warning", "User profile image is not updated");
    }

    public function deleteUserProfileImage($id)
    {
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
            return redirect()->route('admin.user.index')->with("success", "User profile image is deleted");
        }
        return redirect()->back()->with("warning", "User profile image is not deleted");
    }

    public function updateUserResume(Request $request, $id)
    {
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
            return redirect()->route('admin.user.index')->with("success", "User resume is updated");
        }
        return redirect()->back()->with("warning", "User resume is not updated");
    }

    public function deleteUserResume($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        if ($user->resume_pdf_url) {
            Storage::delete($user->resume_pdf_url);
        }
        $data = [
            "resume_pdf_url" => null,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('admin.user.index')->with("success", "User resume is deleted");
        }
        return redirect()->back()->with("warning", "User resume is not deleted");
    }
}
