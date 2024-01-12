<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required|min:5|max:30",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
            "password_confirmation" => "required|min:8|same:password",
        ]);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => $request->get("password"),
                "password_confirmation" => $request->get("password_confirmation"),
            ];
            $isCreated = User::create($data);
            if ($isCreated) {
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
        $user = User::all()->toArray();
        return view('admin.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::where('id', $id)->get()->ToArray();
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        return view('admin.user.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::where('id', $id)->get()->ToArray();
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
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
            $isUpdated = User::find($id)->update($data);
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
        $isDeleted = User::where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.user.index')->with('success', 'User is deleted');
        }
        return redirect()->back()->with("warning", "User is not deleted");
    }
}
