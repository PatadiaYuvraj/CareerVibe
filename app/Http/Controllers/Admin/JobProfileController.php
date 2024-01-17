<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobProfile;
use Illuminate\Http\Request;

class JobProfileController extends Controller
{

    private JobProfile $profile;

    public function __construct(JobProfile $profile)
    {
        $this->profile = $profile;
    }


    public function create()
    {
        return view('admin.job-profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "profile" => [
                "required",
                "string",
                "max:100",
                "unique:job_profiles,profile",
            ]
        ]);
        $data = [
            "profile" => $request->get("profile"),
        ];
        $isCreated = $this->profile->create($data);
        if ($isCreated) {
            return redirect()->route('admin.job-profile.index')->with('success', 'Job Profile is created');
        }
        return redirect()->back()->with("warning", "Job Profile is not created");
    }

    public function index()
    {
        $profiles = $this->profile->withCount('jobs')->paginate(5);
        return view('admin.job-profile.index', compact('profiles'));
    }

    public function show($id)
    {
        $profile = $this->profile->where('id', $id)->with(['jobs'])->get()->toArray();
        if (!$profile) {
            return redirect()->back()->with("warning", "Profile is not found");
        }
        $profile =  $profile[0];
        return view('admin.job-profile.show', compact('profile'));
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
        $request->validate([
            "profile" => [
                "required",
                "string",
                "max:100",
                "unique:job_profiles,profile",
            ]
        ]);
        $data = [
            "profile" => $request->get("profile"),
        ];
        $isUpdated = $this->profile->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('admin.job-profile.index')->with('success', 'Job Profile is updated');
        }
        return redirect()->back()->with("warning", "Job Profile is not updated");
    }

    public function delete($id)
    {
        $profile = $this->profile->where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$profile) {
            return redirect()->back()->with("warning", "Job Profile is not found");
        }
        $profile =  $profile[0];
        if ($profile['jobs_count'] == 0) {
            $isDeleted = $this->profile->where('id', $id)->delete();
            if ($isDeleted) {
                return redirect()->route('admin.job-profile.index')->with('success', 'Job Profile is deleted');
            }
            return redirect()->back()->with("warning", "Job Profile is not deleted");
        }
        return redirect()->back()->with("warning", "Job Profile is not deleted, because it has jobs associated with it");
    }
}
