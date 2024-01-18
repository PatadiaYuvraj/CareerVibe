<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\Location;
use App\Models\Qualification;
use App\Models\SubProfile;
use App\Services\AuthService;
use Illuminate\Http\Request;

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
        if (!$this->auth->isAdmin() && !$this->auth->isCompany()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $company = Company::where('id', $company_id)->select(['id', 'name', 'is_verified'])->get()->toArray();
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company = $company[0];
        if ($company['is_verified'] == 0) {
            return redirect()->back()->with("warning", "Company is not verified");
        }

        $sub_profiles = SubProfile::select([
            'id',
            'name',
            'profile_category_id'
        ])->with([
            'profileCategory' =>
            function ($query) {
                $query->select(['id', 'name']);
            }
        ])->get()->toArray();

        $locations = Location::select(['id', 'city', 'state'])->get()->toArray();

        $qualifications = Qualification::select(['id', 'name'])->get()->toArray();

        $work_types = [
            "REMOTE",
            "WFO",
            "HYBRID"
        ];
        // dd([
        //     "company" => $company,
        //     "sub_profiles" => $sub_profiles,
        //     "locations" => $locations,
        //     "qualifications" => $qualifications,
        //     "work_types" => $work_types,

        // ]);
        return view('admin.job.create', compact('company', 'sub_profiles', 'locations', 'qualifications', 'work_types'));
    }

    public function store(Request $request, $id)
    {
        $request->validate(
            [
                "sub_profile_id" =>
                [
                    "required",
                    "string",
                    "max:100",
                    function ($attribute, $value, $fail) {
                        if (!SubProfile::where('id', $value)->exists()) {
                            $fail("The selected $attribute is invalid.");
                        }
                    },

                ],
                "vacancy" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) {
                        if ($value <= 0) {
                            $fail("The $attribute must be greater than 0.");
                        }
                    },
                ],
                "min_salary" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= 0) {
                            $fail("The minimum salary must be greater than 0.");
                        }

                        if ($value > $request->get('max_salary')) {
                            $fail("The minimum salary must be less than max salary.");
                        }
                    },

                ],
                "max_salary" => [
                    "required",
                    "integer",
                    // greater than min_salary
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= $request->get('min_salary')) {
                            $fail("The $attribute must be greater than min salary.");
                        }
                    },
                ],
                "locations" => [
                    "required",
                    "array",
                    function ($attribute, $value, $fail) {
                        foreach ($value as $id) {
                            if (!Location::where('id', $id)->exists()) {
                                $fail("The selected $attribute is invalid.");
                            }
                        }
                    },
                ],
                "qualifications" => [
                    "required",
                    "array",
                    function ($attribute, $value, $fail) {
                        foreach ($value as $id) {
                            if (!Qualification::where('id', $id)->exists()) {
                                $fail("The selected $attribute is invalid.");
                            }
                        }
                    },
                ],
            ]
        );
        $data = [
            "company_id" => $id,
            "sub_profile_id" => $request->get("sub_profile_id"),
            "vacancy" => $request->get("vacancy"),
            "min_salary" => $request->get("min_salary"),
            "max_salary" => $request->get("max_salary"),
        ];

        if ($request->get('description')) {
            $request->validate([
                "description" => "required|string",
            ]);
            $data['description'] = $request->get('description');
        }
        if ($request->get('responsibility')) {
            $request->validate([
                "responsibility" => "required|string",
            ]);
            $data['responsibility'] = $request->get('responsibility');
        }
        if ($request->get('benifits_perks')) {
            $request->validate([
                "benifits_perks" => "required|string",
            ]);
            $data['benifits_perks'] = $request->get('benifits_perks');
        }
        if ($request->get('other_benifits')) {
            $request->validate([
                "other_benifits" => "required|string",
            ]);
            $data['other_benifits'] = $request->get('other_benifits');
        }
        if ($request->get('keywords')) {
            $request->validate([
                "keywords" => "required|string",
            ]);
            $data['keywords'] = $request->get('keywords');
        }
        if ($request->get('work_type')) {
            $request->validate([
                "work_type" => "required|string|in:REMOTE,WFO,HYBRID",
            ]);
            $data['work_type'] = $request->get('work_type');
        }

        if ($request->get('job_type')) {
            $request->validate([
                "job_type" => "required|string|in:FULL_TIME,PART_TIME,INTERNSHIP,CONTRACT",
            ]);
            $data['job_type'] = $request->get('job_type');
        }

        if ($request->get('experience_level')) {
            $request->validate([
                "experience_level" => "required|string|in:FRESHER,EXPERIENCED",
            ]);
            $data['experience_level'] = $request->get('experience_level');
        }

        if ($request->get('experience_type')) {
            $request->validate([
                "experience_type" => "required|string|in:ANY,1-2,2-3,3-5,5-8,8-10,10+",
            ]);
            $data['experience_type'] = $request->get('experience_type');
        }

        $data['is_verified'] = 0;
        $data['is_featured'] = 0;
        $data['is_active'] = 1;
        $isCreated = $this->job->create($data);

        // dd($isCreated);

        if ($isCreated) {
            $isCreated->locations()->attach($request->get('locations'));
            $isCreated->qualifications()->attach($request->get('qualifications'));
            return redirect()->route('admin.job.index')->with('success', 'Job is created');
        }
        return redirect()->back()->with("warning", "Job is not created");
    }

    public function index()
    {
        $jobs = $this->job->with([
            'subProfile' => function ($query) {
                $query->select(
                    ['id', 'name', 'profile_category_id']
                );
                $query->with(
                    [
                        'profileCategory' => function ($query) {
                            $query->select(['id', 'name']);
                        }
                    ]
                );
            },
        ])->paginate(10);
        return view('admin.job.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = $this->job->where('id', $id)->with(
            [
                'profile' => function ($query) {
                    $query->select(['job_profiles.id', 'profile']);
                },
                "company" => function ($query) {
                    $query->select(['companies.id', 'name', 'email']);
                },
                "qualifications" => function ($query) {
                    $query->select(['qualifications.id', 'name']);
                },
                "locations" => function ($query) {
                    $query->select(['locations.id', 'city', 'state']);
                }
            ]
        )->get()->ToArray();
        if (!$job) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        $job = $job[0];
        return view('admin.job.show', compact('job'));
    }

    public function edit($id)
    {
        $job = $this->job->where('id', $id)->with([
            'subProfile' => function ($query) {
                $query->select(['id', 'name', 'profile_category_id']);
                $query->with(['profileCategory' => function ($query) {
                    $query->select(['id', 'name']);
                }]);
            }, "qualifications" => function ($query) {
                $query->select(['qualifications.id', 'name']);
            }, "locations" => function ($query) {
                $query->select(['locations.id', 'city', 'state']);
            }
        ])->get()->toArray();
        $qualifications = Qualification::select([
            'id',
            'name'
        ])->get()->toArray();
        $locations = Location::select([
            'id',
            'city',
            'state'
        ])->get()->toArray();
        $sub_profiles = SubProfile::select([
            'id',
            'name',
            'profile_category_id'

        ])->with([
            'profileCategory' => function ($query) {
                $query->select(['id', 'name']);
            }
        ])->get()->toArray();
        if (!$job) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        $job  =  $job[0];
        // dd([
        //     "job" => $job,
        //     "qualifications" => $qualifications,
        //     "locations" => $locations,
        //     "sub_profiles" => $sub_profiles,

        // ]);
        return view('admin.job.edit', compact('job', 'qualifications', 'locations', 'sub_profiles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                "sub_profile_id" =>
                [
                    "required",
                    "string",
                    "max:100",
                    function ($attribute, $value, $fail) {
                        if (!SubProfile::where('id', $value)->exists()) {
                            $fail("The selected $attribute is invalid.");
                        }
                    },

                ],
                "vacancy" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) {
                        if ($value <= 0) {
                            $fail("The $attribute must be greater than 0.");
                        }
                    },
                ],
                "min_salary" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= 0) {
                            $fail("The minimum salary must be greater than 0.");
                        }

                        if ($value > $request->get('max_salary')) {
                            $fail("The minimum salary must be less than max salary.");
                        }
                    },

                ],
                "max_salary" => [
                    "required",
                    "integer",
                    // greater than min_salary
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= $request->get('min_salary')) {
                            $fail("The $attribute must be greater than min salary.");
                        }
                    },
                ],
                "locations" => [
                    "required",
                    "array",
                    function ($attribute, $value, $fail) {
                        foreach ($value as $id) {
                            if (!Location::where('id', $id)->exists()) {
                                $fail("The selected $attribute is invalid.");
                            }
                        }
                    },
                ],
                "qualifications" => [
                    "required",
                    "array",
                    function ($attribute, $value, $fail) {
                        foreach ($value as $id) {
                            if (!Qualification::where('id', $id)->exists()) {
                                $fail("The selected $attribute is invalid.");
                            }
                        }
                    },
                ],
            ]
        );
        $data = [
            "sub_profile_id" => $request->get("sub_profile_id"),
            "vacancy" => $request->get("vacancy"),
            "min_salary" => $request->get("min_salary"),
            "max_salary" => $request->get("max_salary"),
        ];

        if ($request->get('description')) {
            $request->validate([
                "description" => "required|string",
            ]);
            $data['description'] = $request->get('description');
        }
        if ($request->get('responsibility')) {
            $request->validate([
                "responsibility" => "required|string",
            ]);
            $data['responsibility'] = $request->get('responsibility');
        }
        if ($request->get('benifits_perks')) {
            $request->validate([
                "benifits_perks" => "required|string",
            ]);
            $data['benifits_perks'] = $request->get('benifits_perks');
        }
        if ($request->get('other_benifits')) {
            $request->validate([
                "other_benifits" => "required|string",
            ]);
            $data['other_benifits'] = $request->get('other_benifits');
        }
        if ($request->get('keywords')) {
            $request->validate([
                "keywords" => "required|string",
            ]);
            $data['keywords'] = $request->get('keywords');
        }
        if ($request->get('work_type')) {
            $request->validate([
                "work_type" => "required|string|in:REMOTE,WFO,HYBRID",
            ]);
            $data['work_type'] = $request->get('work_type');
        }

        if ($request->get('job_type')) {
            $request->validate([
                "job_type" => "required|string|in:FULL_TIME,PART_TIME,INTERNSHIP,CONTRACT",
            ]);
            $data['job_type'] = $request->get('job_type');
        }

        if ($request->get('experience_level')) {
            $request->validate([
                "experience_level" => "required|string|in:FRESHER,EXPERIENCED",
            ]);
            $data['experience_level'] = $request->get('experience_level');
        }

        if ($request->get('experience_type')) {
            $request->validate([
                "experience_type" => "required|string|in:ANY,1-2,2-3,3-5,5-8,8-10,10+",
            ]);
            $data['experience_type'] = $request->get('experience_type');
        }

        $isUpdated = $this->job->find($id);
        $isUpdated->update($data);
        if ($isUpdated) {
            $d = $isUpdated->qualifications()->sync($request->get('qualifications'));
            $isUpdated->locations()->sync($request->get('locations'));
            return redirect()->route('admin.job.index')->with('success', 'Job is updated');
        }
        return redirect()->back()->with("warning", "Job is not updated");
    }

    public function delete($id)
    {
        // delete job with locatoin and qualification
        $isDeleted = $this->job->find($id);
        // delete job with locatoin and qualification
        $isDeleted->locations()->detach();
        $isDeleted->qualifications()->detach();
        $isDeleted->delete();
        if (!$isDeleted) {
            return redirect()->back()->with("warning", "Job is not found");
        }
        return redirect()->route('admin.job.index')->with('success', 'Job is deleted');
    }

    public function toggleVerified($id, $is_verified)
    {
        if (!$this->auth->isAdmin()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }
        $job = $this->job->find($id);
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
        $job = $this->job->find($id);
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
        $job = $this->job->find($id);
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
