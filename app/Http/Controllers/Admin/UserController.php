<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NavigationManagerService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private User $user;
    private int $paginate;
    private StorageManagerService $storageManagerService;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        User $user,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->user = $user;
        $this->paginate = Config::get('constants.pagination');
    }

    public function create()
    {
        return $this->navigationManagerService->loadView('admin.user.create');
    }

    public function store(Request $request)
    {
        $hasFile = false;
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:25'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    if ($user) {
                        return $fail('Email is already exist');
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:100',
                'confirmed'
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8',
                'max:100',
                'same:password'
            ],
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

            $data["profile_image_public_id"] = null;
            $data["profile_image_url"] = null;
            $hasFile = true;
        }

        if ($request->file('resume_pdf_url')) {
            $request->validate([
                "resume_pdf_url" => ["required", "mimes:pdf", "max:2048",],
            ]);
            $stored_path = $this->storageManagerService->uploadToLocal($request, "resume_pdf_url");
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
                'gender' => [
                    'required',
                    'string',
                    'in:' . implode(',', array_keys(Config::get('constants.gender'))),
                ],
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
            $msg = "User is created";
            if ($hasFile) {
                $this->storageManagerService->uploadToCloudinary($request, "USER", $isCreated->id);
            }
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => $msg]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not created"]);
    }

    public function index()
    {
        $users = $this->user
            ->withCount([
                'followers',
                'following',
                'followingCompanies',
                'savedJobs',
                'appliedJobs'
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = $this->user->where('id', $id)->get()->ToArray();
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user  =  $user[0];
        dd($user);
        return $this->navigationManagerService->loadView('admin.user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->user->where('id', $id)->get()->ToArray();
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user  =  $user[0];
        return $this->navigationManagerService->loadView('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email,' . $id],
        ]);
        $data = [
            "name" => $request->name,
            "email" => $request->email,
        ];

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
                $this->storageManagerService->deleteFromCloudinary($public_ids);
            }

            $this->storageManagerService->uploadToCloudinary($request, "USER", $user->id);

            $data["profile_image_public_id"] = null;
            $data["profile_image_url"] = null;
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
                $this->storageManagerService->deleteFromLocal($user->resume_pdf_url);
            }

            $stored_path = $this->storageManagerService->uploadToLocal($request, "resume_pdf_url");
            $data["resume_pdf_url"] = $stored_path;
            $data["resume_pdf_public_id"] = null;
        }

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
                    'in:' . implode(',', array_keys(Config::get('constants.gender'))),
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
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => "User is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not updated"]);
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }
        if ($user->resume_pdf_url) {
            $this->storageManagerService->deleteFromLocal($user->resume_pdf_url);
        }
        $isDeleted = $this->user->where('id', $id)->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => "User is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not deleted"]);
    }

    public function passwordReset($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        return $this->navigationManagerService->loadView('admin.user.password-reset', compact('user'));
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
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Old password is not matched"]);
        }

        $data = [
            "password" => Hash::make($request->new_password),
        ];

        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => "User password is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User password is not updated"]);
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
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }
        $this->storageManagerService->uploadToCloudinary($request, "USER", $user->id);

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => "User profile image is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User profile image is not updated"]);
    }

    public function deleteUserProfileImage($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }
        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => "User profile image is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User profile image is not deleted"]);
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
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        if ($user->resume_pdf_url) {
            $this->storageManagerService->deleteFromLocal($user->resume_pdf_url);
        }
        $stored_path = $this->storageManagerService->uploadToLocal($request, "resume_pdf_url");
        $data = [
            "resume_pdf_url" => $stored_path,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => "User resume is updated"]);
        }
        return  $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User resume is not updated"]);
    }

    public function deleteUserResume($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        if ($user->resume_pdf_url) {
            $this->storageManagerService->deleteFromLocal($user->resume_pdf_url);
        }
        $data = [
            "resume_pdf_url" => null,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.user.index', [], 302, [], false, ["success" => "User resume is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User resume is not deleted"]);
    }

    public function follow($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $isFollowed = $user->followers()->attach(auth()->user()->id);
        if ($isFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is followed"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
    }

    public function unfollow($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $isUnfollowed = $user->followers()->detach(auth()->user()->id);
        if ($isUnfollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not unfollowed"]);
    }

    public function livewire()
    {
        return $this->navigationManagerService->loadView('admin.user.index-livewire');
    }


    public function following($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $following = $user->following()->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.user.following', compact('following'));
    }

    public function followers($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $followers = $user->followers()->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.user.followers', compact('followers'));
    }
}
