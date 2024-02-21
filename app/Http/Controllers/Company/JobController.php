<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Job;
use App\Models\Location;
use App\Models\ProfileCategory;
use App\Models\Qualification;
use App\Models\SubProfile;
use App\Services\AuthenticableService;
use App\Services\MailableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class JobController extends Controller
{
    private Job $job;
    private MailableService $mailableService;
    private NotifiableService $notifiableService;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private int $paginate;


    public function __construct(
        Job $job,
        MailableService $mailableService,
        NotifiableService $notifiableService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->job = $job;
        $this->paginate = Config::get('constants.pagination');
        $this->mailableService = $mailableService;
        $this->notifiableService = $notifiableService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
    }

    public function index()
    {
        $company_id = $this->authenticableService->getCompany()->id;

        $jobs = $this->job
            ->where('company_id', $company_id)
            ->with([
                'subProfile' => function ($query) {
                    $query->select([
                        'id',
                        'name'
                    ]);
                },
                'applyByUsers' => function ($query) {
                    $query->select([
                        'users.id',
                        'name',
                        'email'
                    ]);
                },
            ])
            ->select([
                'id',
                'sub_profile_id',
                'vacancy',
                'min_salary',
                'max_salary',
                'work_type',
                'is_verified',
                'is_active',
                'is_featured'
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin_company.job.index', compact('jobs'));
    }

    public function create()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        if ($company->is_verified == 0) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not verified"]);
        }

        $profile_categories = ProfileCategory::with([
            'subProfiles' => function ($query) {
                $query->select([
                    'id', 'name', 'profile_category_id'
                ]);
            }
        ])->select(['id', 'name'])->get()->toArray();


        $locations = Location::select(['id', 'city', 'state'])->get()->toArray();

        $qualifications = Qualification::select(['id', 'name'])->get()->toArray();
        return $this->navigationManagerService->loadView('admin_company.job.create', compact(
            'company',
            // 'sub_profiles',
            'profile_categories',
            'locations',
            'qualifications'
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $company = $this->authenticableService->getCompany();
        if (!$company->id) {
            return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["warning" => "Company is not found"]);
        }
        if ($company->is_verified == 0) {
            return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["warning" => "Company is not verified"]);
        }
        $request->validate([
            "sub_profile_id" => [
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
        ]);
        $data = [
            // "company_id" => $company->id,
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
                ],
            ]);
            $data['experience_type'] = $request->get('experience_type');
        }

        $data['is_verified'] = 0;
        $data['is_featured'] = 0;
        $data['is_active'] = 1;
        $isCreated = $company->jobs()->create($data);

        if ($isCreated) {
            $isCreated->locations()->attach($request->get('locations'));
            $isCreated->qualifications()->attach($request->get('qualifications'));

            $profileName = $isCreated->subProfile->name;
            $msg = "Your job for $profileName profile is created successfully";
            $details = [
                'title' => 'Job Created',
                'body' => "Your job for $profileName profile is created successfully. Admin will verify it."
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $msg);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);

            $admins = Admin::all();
            $details = [
                'title' => 'New Job Created',
                'body' => "New job for $profileName profile is created by $company->name company. Please verify it."
            ];
            foreach ($admins as $admin) {
                // UNCOMMENT: To send notification
                $this->notifiableService->sendNotification($admin, $details['body']);
                // UNCOMMENT: To send mail
                $this->mailableService->sendMail($admin->email, $details);
            }

            return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["success" => "Job is created"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not created"]);
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
        return $this->navigationManagerService->loadView('admin_company.job.show', compact('job'));
    }

    public function edit($id)
    {


        $user_id = $this->authenticableService->getCompany()->id;
        // check this job is created by this company
        $job = $this->job
            ->where('company_id', $user_id)
            ->find($id);

        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "The job is not created by this company."]);
        }
        $job = $this->job->where('id', $id)->with(
            [
                'company',
                'subProfile' => function ($query) {
                    $query->select(['id', 'name']);
                }, "qualifications" => function ($query) {
                    $query->select(['qualifications.id', 'name']);
                }, "locations" => function ($query) {
                    $query->select(['locations.id', 'city', 'state']);
                }
            ]
        )->get()->toArray();
        $qualifications = Qualification::select([
            'id',
            'name',
        ])->get()->toArray();
        $locations = Location::select([
            'id',
            'city',
            'state'
        ])->get()->toArray();
        $profile_categories = ProfileCategory::with([
            'subProfiles' => function ($query) {
                $query->select(['id', 'name', 'profile_category_id']);
            }
        ])->select(['id', 'name'])->get()->toArray();
        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        $job  =  $job[0];
        return $this->navigationManagerService->loadView('admin_company.job.edit', compact('job', 'qualifications', 'locations', 'profile_categories'));
    }

    public function update(Request $request, $id)
    {
        $isExists = $this->job->find($id);
        if (!$isExists) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }

        $request->validate([
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
        ]);
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
                ],
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
                ],
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
                ],
            ]);
            $data['experience_type'] = $request->get('experience_type');
        }

        $isUpdated = $this->job->find($id); // but dont change company_id
        $isUpdated->update($data);
        if ($isUpdated) {
            $isUpdated->qualifications()->sync($request->get('qualifications'));
            $isUpdated->locations()->sync($request->get('locations'));
            return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["success" => "Job is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not updated"]);
    }

    public function delete($id)
    {
        $user_id = $this->authenticableService->getCompany()->id;
        $isDeleted = $this->job
            ->where('company_id', $user_id)
            ->find($id);
        if (!$isDeleted) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "The job is not created by this company."]);
        }

        $isDeleted->locations()->detach(); // delete all locations
        $isDeleted->qualifications()->detach(); // delete all qualifications
        $isDeleted->delete(); // delete job
        if (!$isDeleted) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["success" => "Job is deleted"]);
    }

    public function toggleFeatured($id, $is_featured)
    {
        $user_id = $this->authenticableService->getCompany()->id;
        $job = $this->job
            ->where('company_id', $user_id)
            ->find($id);
        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        if ($is_featured == 1) {
            $job->is_featured = 0;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company is unfeatured"]);
        } else {
            $job->is_featured = 1;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company is featured"]);
        }
        return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["success" => "Job is updated"]);
    }

    public function toggleActive($id, $is_active)
    {
        $user_id = $this->authenticableService->getCompany()->id;
        $job = $this->job
            ->where('company_id', $user_id)
            ->find($id);
        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        if ($is_active == 1) {
            $job->is_active = 0;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company is unaactive"]);
        } else {
            $job->is_active = 1;
            $job->save();
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company is active"]);
        }
        return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["success" => "Job is updated"]);
    }
}
