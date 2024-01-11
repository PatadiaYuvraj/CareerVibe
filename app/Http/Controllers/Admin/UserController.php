<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private UserService $user;

    public function __construct(UserService $demo)
    {
        $this->user = $demo;
    }
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validate = $this->user->validateUser($request, true);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => $request->get("password"),
                "password_confirmation" => $request->get("password_confirmation"),
            ];
            $isCreated = $this->user->createUser($data);
            if ($isCreated['status']) {
                return redirect()->route('admin.user.index')->with('success', 'User is created');
            }
            return redirect()->back()->with("warning", "User is not created");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function index()
    {

        // method getUsers returns status, msg, data
        $data = $this->user->getUsers();
        $users = $data['data'];
        return view('admin.user.index', compact('users'));
    }

    // public function show($id)
    // {
    //     $user = $this->user->getUserById($id);
    //     return view('admin.user.show', compact('user'));
    // }


    public function edit($id)
    {
        $data = $this->user->getUserById($id);
        $user = $data['data'];
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
            $isUpdated = $this->user->updateUser($id, $data);
            if ($isUpdated['status']) {
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
        $isDeleted = $this->user->deleteUser($id);
        if ($isDeleted) {
            return redirect()->route('admin.user.index')->with('success', 'User is deleted');
        }
        return redirect()->back()->with("warning", "User is not deleted");
    }
}
