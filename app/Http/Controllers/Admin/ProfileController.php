<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function create()
    {
        return view('admin.job-profile.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "profile" => "required|string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "profile" => $request->get("profile"),
            ];
            $isCreated = Profile::create($data);
            if ($isCreated) {
                return redirect()->route('admin.job-profile.index')->with('success', 'Profile is created');
            }
            return redirect()->back()->with("warning", "Profile is not created");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function index()
    {
        $profiles = Profile::all()->toArray();
        return view('admin.job-profile.index', compact('profiles'));
    }

    // public function show($id)
    // {
    //     $Profile = Profile::where('id', $id)->get()->ToArray();
    //     return view('admin.Profile.show', compact('Profile'));
    // }

    public function edit($id)
    {
        $profile = Profile::where('id', $id)->get()->ToArray();
        if (!$profile) {
            return redirect()->back()->with("warning", "Profile is not found");
        }
        return view('admin.job-profile.edit', compact('profile'));
    }


    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            "profile" => "required|string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "profile" => $request->get("profile"),
            ];
            $isUpdated = Profile::where('id', $id)->update($data);
            if ($isUpdated) {
                return redirect()->route('admin.job-profile.index')->with('success', 'Profile is updated');
            }
            return redirect()->back()->with("warning", "Profile is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function delete($id)
    {
        $isDeleted = Profile::where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.job-profile.index')->with('success', 'Profile is deleted');
        }
        return redirect()->back()->with("warning", "Profile is not deleted");
    }
}
