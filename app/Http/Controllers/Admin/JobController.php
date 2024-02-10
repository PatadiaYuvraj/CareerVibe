<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Location;
use App\Models\ProfileCategory;
use App\Models\Qualification;
use App\Models\SubProfile;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class JobController extends Controller
{
    private Job $job;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(
        Job $job,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->paginate = Config::get('constants.pagination');
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->job = $job;
    }

    public function create($company_id)
    {

        $company = $this->authenticableService->getCompanyById($company_id);
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        if ($company->is_verified == 0) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not verified"]);
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

        $profile_categories = ProfileCategory::with([
            'subProfiles' => function ($query) {
                $query->select(['id', 'name', 'profile_category_id']);
            }
        ])->select(['id', 'name'])->get()->toArray();

        $locations = Location::select(['id', 'city', 'state'])->get()->toArray();

        $qualifications = Qualification::select(['id', 'name'])->get()->toArray();

        return $this->navigationManagerService->loadView('admin.job.create', compact(
            'company',
            // 'sub_profiles',
            'profile_categories',
            'locations',
            'qualifications'
        ));
    }

    public function store(Request $request, $id)
    {

        dd($request->all());
        $company = $this->authenticableService->getCompanyById($id);
        if (!$company->is_verified) {
            return $this->navigationManagerService->redirectRoute('admin.company.index', [], 302, [], false, ["warning" => "Company is not verified"]);
        }

        $request->validate(
            [
                "sub_profile_id" =>
                [
                    "required",
                    "string",
                    "max:100",
                    function ($attribute, $value, $fail) {
                        if (!SubProfile::where('id', $value)->exists()) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },

                ],
                "vacancy" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) {
                        if ($value <= 0) {
                            return $fail("The $attribute must be greater than 0.");
                        }
                    },
                ],
                "min_salary" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= 0) {
                            return $fail("The minimum salary must be greater than 0.");
                        }

                        if ($value > $request->get('max_salary')) {
                            return $fail("The minimum salary must be less than max salary.");
                        }
                    },

                ],
                "max_salary" => [
                    "required",
                    "integer",
                    // greater than min_salary
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= $request->get('min_salary')) {
                            return $fail("The $attribute must be greater than min salary.");
                        }
                    },
                ],
                "locations" => [
                    "required",
                    "array",
                    function ($attribute, $value, $fail) {
                        foreach ($value as $id) {
                            if (!Location::where('id', $id)->exists()) {
                                return $fail("The selected $attribute is invalid.");
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
                                return $fail("The selected $attribute is invalid.");
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
                "work_type" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.work_type'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ],
            ]);
            $data['work_type'] = $request->get('work_type');
        }

        if ($request->get('job_type')) {
            $request->validate([
                "job_type" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.job_type'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ]
            ]);
            $data['job_type'] = $request->get('job_type');
        }

        if ($request->get('experience_level')) {
            $request->validate([
                "experience_level" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.experience_level'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ]
            ]);
            $data['experience_level'] = $request->get('experience_level');
        }

        if ($request->get('experience_type')) {
            $request->validate([
                "experience_type" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.experience_type'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ]
            ]);
            $data['experience_type'] = $request->get('experience_type');
        }

        $data['is_verified'] = 0;
        $data['is_featured'] = 0;
        $data['is_active'] = 1;
        $isCreated = $company->jobs()->create($data);

        // dd($isCreated);

        if ($isCreated) {
            $isCreated->locations()->attach($request->get('locations'));
            $isCreated->qualifications()->attach($request->get('qualifications'));
            return $this->navigationManagerService->redirectRoute('admin.job.index', [], 302, [], false, ["success" => "Job is created"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not created"]);
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
        ])->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.job.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = $this->job->where('id', $id)->with(
            [
                'subProfile' => function ($query) {
                    $query->select(['sub_profiles.id', 'name']);
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
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        $job = $job[0];
        return $this->navigationManagerService->loadView('admin.job.show', compact('job'));
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
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        $job  =  $job[0];
        return $this->navigationManagerService->loadView('admin.job.edit', compact('job', 'qualifications', 'locations', 'sub_profiles'));
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
                            return $fail("The selected $attribute is invalid.");
                        }
                    },

                ],
                "vacancy" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) {
                        if ($value <= 0) {
                            return $fail("The $attribute must be greater than 0.");
                        }
                    },
                ],
                "min_salary" => [
                    "required",
                    "integer",
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= 0) {
                            return $fail("The minimum salary must be greater than 0.");
                        }

                        if ($value > $request->get('max_salary')) {
                            return $fail("The minimum salary must be less than max salary.");
                        }
                    },

                ],
                "max_salary" => [
                    "required",
                    "integer",
                    // greater than min_salary
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value <= $request->get('min_salary')) {
                            return $fail("The $attribute must be greater than min salary.");
                        }
                    },
                ],
                "locations" => [
                    "required",
                    "array",
                    function ($attribute, $value, $fail) {
                        foreach ($value as $id) {
                            if (!Location::where('id', $id)->exists()) {
                                return $fail("The selected $attribute is invalid.");
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
                                return $fail("The selected $attribute is invalid.");
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


        $data['description'] = $data['responsibility'] = $data['benifits_perks'] = $data['other_benifits'] = $data['keywords'] = $data['work_type'] = $data['job_type'] = $data['experience_level'] = $data['experience_type'] = null;
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
                "work_type" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.work_type'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ]
            ]);
            $data['work_type'] = $request->get('work_type');
        }

        if ($request->get('job_type')) {
            $request->validate([
                "job_type" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.job_type'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ]
            ]);
            $data['job_type'] = $request->get('job_type');
        }

        if ($request->get('experience_level')) {
            $request->validate([
                "experience_level" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.experience_level'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ]
            ]);
            $data['experience_level'] = $request->get('experience_level');
        }

        if ($request->get('experience_type')) {
            $request->validate([
                "experience_type" => [
                    "required",
                    "string",
                    function ($attribute, $value, $fail) {
                        if (!array_key_exists($value, Config::get('constants.job.experience_type'))) {
                            return $fail("The selected $attribute is invalid.");
                        }
                    },
                ]
            ]);
            $data['experience_type'] = $request->get('experience_type');
        }

        $isUpdated = $this->job->find($id);
        $isUpdated->update($data);
        if ($isUpdated) {
            $isUpdated->qualifications()->sync($request->get('qualifications'));
            $isUpdated->locations()->sync($request->get('locations'));
            return $this->navigationManagerService->redirectRoute('admin.job.index', [], 302, [], false, ["success" => "Job is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not updated"]);
    }

    public function delete($id)
    {
        // delete job with locatoin and qualification
        $isDeleted = $this->job->find($id);
        // delete job with locatoin and qualification
        $isDeleted->locations()->detach();
        $isDeleted->qualifications()->detach();
        $isDeleted->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('admin.job.index', [], 302, [], false, ["success" => "Job is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not deleted"]);
    }

    public function toggleVerified($id, $is_verified)
    {

        $job = $this->job->find($id);
        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        if ($is_verified == 1) {
            $job->is_verified = 0;
            $job->save();
            // MAIL: send mail to company that job is unverified
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job is unverified"]);
        } else {
            $job->is_verified = 1;
            $job->save();
            // MAIL: send mail to company that job is verified
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job is verified"]);
        }
    }

    public function toggleFeatured($id, $is_featured)
    {
        $job = $this->job->find($id);
        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        if ($is_featured == 1) {
            $job->is_featured = 0;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job is unfeatured"]);
        } else {
            $job->is_featured = 1;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job is featured"]);
        }
    }

    public function toggleActive($id, $is_active)
    {
        $job = $this->job->find($id);
        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        if ($is_active == 1) {
            $job->is_active = 0;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job is unactive"]);
        } else {
            $job->is_active = 1;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job is active"]);
        }
    }
}
