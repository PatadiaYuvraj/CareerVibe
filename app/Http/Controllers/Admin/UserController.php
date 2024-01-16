<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            "name" => "required|min:5|max:30",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
            "password_confirmation" => "required|min:8|same:password",
        ]);
        // $data = [
        //     "name" => $request->get("name"),
        //     "email" => $request->get("email"),
        //     "password" => $request->get("password"),
        //     "password_confirmation" => $request->get("password_confirmation"),
        // ];
        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $data['password'] = $request->get('password');
        if ($request->file('profile_image_url')) {
            $request->validate([
                "profile_image_url" => "required|image|mimes:jpeg,png,jpg|max:2048",
            ]);
            $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
            $obj = (new UploadApi())->upload(
                $stored_path,
                [
                    'folder' => 'career-vibe/users/profile_image',
                    'resource_type' => 'image'
                ]
            );

            $data['profile_image_public_id'] = $obj['public_id'];
            $data['profile_image_url'] = $obj['secure_url'];
            unlink($stored_path);
        }
        if ($request->file('resume_pdf_url')) {
            $request->validate([
                "resume_pdf_url" => "required|mimes:pdf|max:2048",
            ]);
            $resume_path = Storage::putFile('temp', $request->file('resume_pdf_url'));

            $data['resume_pdf_url'] = $resume_path;
        }
        if ($request->get('contact')) {
            $request->validate([
                "contact" => "required|numeric",
            ]);
            $data['resume_pdf_url'] = $request->file('resume_pdf_url');
        }
        if ($request->get('city')) {
            $request->validate([
                "city" => "required|string",
            ]);
            $data['city'] = $request->get('city');
        }
        if ($request->get('gender')) {
            $request->validate([
                'gender' => 'required|in:MALE,FEMALE,OTHER|string'
            ]);
        }
        if ($request->get('interest')) {
            $request->validate([
                "interest" => "required|string",
            ]);
            $data['interest'] = $request->get('interest');
        }

        if ($request->get('hobby')) {
            $request->validate([
                "hobby" => "required|string",
            ]);
            $data['hobby'] = $request->get('hobby');
        }

        if ($request->get('education')) {
            $request->validate([
                "education" => "required|string",
            ]);
            $data['education'] = $request->get('education');
        }
        if ($request->get('experience')) {
            $request->validate([
                "experience" => "required|string",
            ]);
            $data['experience'] = $request->get('experience');
        }


        if ($request->get('about')) {
            $request->validate([
                "about" => "required|string",
            ]);
            $data['about'] = $request->get('about');
        }
        // dd($data);
        $isCreated = $this->user->create($data);
        if ($isCreated) {
            return redirect()->route('admin.user.index')->with('success', 'User is created');
        }
        return redirect()->back()->with("warning", "User is not created");
    }

    public function index()
    {
        $users = $this->user->paginate(1);
        return view('admin.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = $this->user->where('id', $id)->get()->ToArray();
        dd($user);
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
        $validate = Validator::make($request->all(), [
            "name" => "required|min:5|max:30",
            "email" => "required|email",
            // "password" => "required|min:8",
        ]);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                // "password" => $request->get("password"),
                // "confirm_password" => $request->get("confirm_password"),
            ];
            $isUpdated = $this->user->where('id', $id)->update($data);
            if ($isUpdated) {
                return redirect()->route('admin.user.index')->with('success', 'User is updated');
            }
            return redirect()->back()->with("warning", "User is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        if ($user->resume_pdf_url) {
            Storage::delete($user->resume_pdf_url);
        }
        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $result = (new AdminApi())->deleteAssets(
                $public_ids,
                ["resource_type" => "image", "type" => "upload"]
            );
            // echo json_encode($result, JSON_PRETTY_PRINT);
        }
        $isDeleted = $user->delete();
        if ($isDeleted) {
            return redirect()->route('admin.user.index')->with('success', 'User is deleted');
        }
        return redirect()->back()->with("warning", "User is not deleted");
    }

    // updateUserProfileImage
    public function updateUserProfileImage(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            "profile_image_url" => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);
        // dd($validate->passes());
        if ($validate->passes()) {
            $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
            $obj = (new UploadApi())->upload(
                $stored_path,
                [
                    'folder' => 'career-vibe/users/profile_image',
                    'resource_type' => 'image'
                ]
            );
            $data = [
                "profile_image_url" => $obj['secure_url'],
            ];
            $isUpdated = $this->user->where('id', $id)->update($data);
            if ($isUpdated) {
                unlink($stored_path);
                return redirect()->route('admin.user.index')->with("success", "User profile image is updated");
            }
            return redirect()->back()->with("warning", "User profile image is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    // updateUserResume
    public function updateUserResume(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            "resume_pdf_url" => "required|mimes:pdf|max:2048",
        ]);
        // dd($validate->passes());
        if ($validate->passes()) {
            $stored_path = Storage::putFile('temp', $request->file('resume_pdf_url'));
            $data = [
                "resume_pdf_url" => $stored_path,
            ];
            $isUpdated = $this->user->where('id', $id)->update($data);
            if ($isUpdated) {
                // unlink($stored_path);
                return redirect()->route('admin.user.index')->with("success", "User resume is updated");
            }
            return redirect()->back()->with("warning", "User resume is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }
}
