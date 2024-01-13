<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobProfile;
use App\Models\Location;
use App\Models\Profile;
use App\Models\Qualification;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    private AuthService $auth;
    private Job $job;

    public function __construct(AuthService $auth, Job $job)
    {
        $this->auth = $auth;

        $this->job = $job;
    }

    public function create($company_id)
    {
        $company = Company::where('id', $company_id)->get()->toArray();
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company = $company[0];
        if ($company['is_verified'] == 0) {
            return redirect()->back()->with("warning", "Company is not verified");
        }
        $job_profiles = JobProfile::all()->toArray();
        $locations = Location::all()->toArray();
        $qualifications = Qualification::all()->toArray();

        // dd($company, $job_profiles, $locations, $qualifications);
        return view('admin.job.create', compact('company', 'job_profiles', 'locations', 'qualifications'));
    }

    public function store(Request $request, $id)
    {
        dd($request->all());

        $validate = Validator::make($request->all(), [
            "job_profile" => "required|string|max:100",
            "vacancy" => "required|integer",
            "min_salary" => "required|integer",
            "max_salary" => "required|integer",
            "description" => "required|string",
            "responsibility" => "required|string",
            "benifits_perks" => "required|string",
            "other_benifits" => "required|string",
            "keywords" => "required|string",
            "work_type" => "required|string|in:REMOTE,WFO,HYBRID",
        ]);
        if ($validate->passes()) {
            $data = [
                "job_profile" => $request->get("job_profile"),
                "vacancy" => $request->get("vacancy"),
                "min_salary" => $request->get("min_salary"),
                "max_salary" => $request->get("max_salary"),
                "description" => $request->get("description"),
                "responsibility" => $request->get("responsibility"),
                "benifits_perks" => $request->get("benifits_perks"),
                "other_benifits" => $request->get("other_benifits"),
                "keywords" => $request->get("keywords"),
                "work_type" => $request->get("work_type"),
            ];
            dd($data);
            $isCreated = $this->job->create($data);
            if ($isCreated) {
                return redirect()->route('admin.job.index')->with('success', 'Job is created');
            }
            return redirect()->back()->with("warning", "Job is not created");
        }
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
    }

    public function index()
    {
        $jobs = $this->job->with(['profile', "company", "qualifications", "locations"])->get()->toArray();
        return view('admin.job.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = $this->job->where('id', $id)->get()->ToArray();
        if (!$job) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        return view('admin.job.show', compact('job'));
    }

    public function edit($id)
    {
        $job = $this->job->where('id', $id)->get()->ToArray();
        if (!$job) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        $job  =  $job[0];
        return view('admin.job.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        // if value is available in request then do not validate that value 
        $validate = Validator::make($request->all(), [
            "job_profile" => "required|string|max:100",
            "vacancy" => "required|integer",
            "min_salary" => "required|integer",
            "max_salary" => "required|integer",
            "description" => "required|string",
            "responsibility" => "required|string",
            "benifits_perks" => "required|string",
            "other_benifits" => "required|string",
            "keywords" => "required|string",
            "work_type" => "required|string",
        ]);
        if ($validate->passes()) {
            $data = [
                "job_profile" => $request->get("job_profile"),
                "vacancy" => $request->get("vacancy"),
                "min_salary" => $request->get("min_salary"),
                "max_salary" => $request->get("max_salary"),
                "description" => $request->get("description"),
                "responsibility" => $request->get("responsibility"),
                "benifits_perks" => $request->get("benifits_perks"),
                "other_benifits" => $request->get("other_benifits"),
                "keywords" => $request->get("keywords"),
                "work_type" => $request->get("work_type"),
            ];
            $isUpdated = $this->job->where('id', $id)->update($data);
            if ($isUpdated) {
                return redirect()->route('admin.job.index')->with('success', 'Job is updated');
            }
            return redirect()->back()->with("warning", "Job is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
    }

    public function delete($id)
    {
        $isDeleted = $this->job->where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.job.index')->with('success', 'Job is deleted');
        }
        return redirect()->back()->with("warning", "Job is not deleted");
    }

    public function toggleVerified($id, $is_verified)
    {

        if (!$this->auth->isAdmin()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }
        $job = $this->job->where('id', $id)->get()->ToArray();
        if (!$job) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        if ($is_verified == 1) {
            $job->is_verified = 0;
            $job->save();
            return redirect()->back()->with('success', 'Company is unverified');
        } else {
            $job->is_verified = 1;
            $job->save();
            return redirect()->back()->with('success', 'Company is verified');
        }
    }

    public function toggleFeatured($id, $is_featured)
    {
        if (!$this->auth->isAdmin() && !$this->auth->isCompany()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }
        $job = $this->job->where('id', $id)->get()->ToArray();
        if (!$job) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        if ($is_featured == 1) {
            $job->is_featured = 0;
            $job->save();
            return redirect()->back()->with('success', 'Company is unverified');
        } else {
            $job->is_featured = 1;
            $job->save();
            return redirect()->back()->with('success', 'Company is verified');
        }
    }

    public function toggleActive($id, $is_active)
    {
        if (!$this->auth->isAdmin() && !$this->auth->isCompany()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }
        $job = $this->job->where('id', $id)->get()->ToArray();
        if (!$job) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        if ($is_active == 1) {
            $job->is_active = 0;
            $job->save();
            return redirect()->back()->with('success', 'Company is unverified');
        } else {
            $job->is_active = 1;
            $job->save();
            return redirect()->back()->with('success', 'Company is verified');
        }
    }
}
