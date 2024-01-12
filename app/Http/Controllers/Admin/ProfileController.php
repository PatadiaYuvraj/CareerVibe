<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    private Profile $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }


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
            $isCreated = $this->profile->create($data);
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
        $profiles = $this->profile->all()->toArray();
        return view('admin.job-profile.index', compact('profiles'));
    }

    public function show($id)
    {
        $profile = $this->profile->where('id', $id)->get()->ToArray();
        if (!$profile) {
            return redirect()->back()->with("warning", "Profile is not found");
        }
        $profile =  $profile[0];
        return view('admin.profile.show', compact('profile'));
    }

    public function edit($id)
    {
        $profile = $this->profile->where('id', $id)->get()->ToArray();
        if (!$profile) {
            return redirect()->back()->with("warning", "Profile is not found");
        }
        $profile =  $profile[0];
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
            $isUpdated = $this->profile->where('id', $id)->update($data);
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
        $isDeleted =  $this->profile->where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.job-profile.index')->with('success', 'Profile is deleted');
        }
        return redirect()->back()->with("warning", "Profile is not deleted");
    }
}
