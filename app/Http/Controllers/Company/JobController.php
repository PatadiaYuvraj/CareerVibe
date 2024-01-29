<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Job;
use App\Models\Location;
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
    private Company $company;
    private Job $job;
    private MailableService $mailableService;
    private NotifiableService $notifiableService;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private $current_company;
    private int $paginate;


    public function __construct(
        Company $company,
        Job $job,
        MailableService $mailableService,
        NotifiableService $notifiableService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->job = $job;
        $this->company = $company;
        $this->paginate = Config::get('constants.pagination');
        $this->mailableService = $mailableService;
        $this->notifiableService = $notifiableService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;

        // AuthenticableService has the following methods:
        // registerUser(array $details): User -> register a new user
        // loginUser(array $details): bool -> login a user
        // logoutUser(): void -> logout a user
        // registerCompany(array $details): Company -> register a new company
        // loginCompany(array $details): bool -> login a company
        // logoutCompany(): void  -> logout a company
        // registerAdmin(array $details): Admin -> register a new admin
        // loginAdmin(array $details): bool -> login an admin
        // logoutAdmin(): void  -> logout an admin
        // passwordHash(string $password): string -> hash a password
        // verifyPassword(string $password, string $hashedPassword): bool -> verify a password
        // isUser(): bool -> check if a user is logged in
        // isCompany(): bool  -> check if a company is logged in
        // isAdmin(): bool  -> check if an admin is logged in
        // getUser(): User  -> get the logged in user
        // getCompany(): Company  -> get the logged in company
        // getAdmin(): Admin  -> get the logged in admin
        // getUserById(int $id): User  -> get a user by id
        // getCompanyById(int $id): Company  -> get a company by id
        // getAdminById(int $id): Admin  -> get an admin by id
        // getUserByEmail(string $email): User  -> get a user by email
        // getCompanyByEmail(string $email): Company  -> get a company by email
        // getAdminByEmail(string $email): Admin  -> get an admin by email
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
        return $this->navigationManagerService->loadView('company.job.index', compact('jobs'));
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

        $sub_profiles = SubProfile::select([
            'id',
            'name',
            'profile_category_id'
        ])
            // ->with([
            //     'profileCategory' =>
            //     function ($query) {
            //         $query->select(['id', 'name']);
            //     }
            // ])
            ->get()->toArray();

        $locations = Location::select(['id', 'city', 'state'])->get()->toArray();

        $qualifications = Qualification::select(['id', 'name'])->get()->toArray();

        $work_types = [
            "REMOTE",
            "WFO",
            "HYBRID"
        ];
        return $this->navigationManagerService->loadView('company.job.create', compact('company', 'sub_profiles', 'locations', 'qualifications', 'work_types'));
    }

    public function store(Request $request)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company->id) {
            return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["warning" => "Company is not found"]);
        }
        if ($company->is_verified == 0) {
            return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["warning" => "Company is not verified"]);
        }
        $request->validate([
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
        $company_id = $this->current_company->id;

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
        return $this->navigationManagerService->loadView('company.job.show', compact('job'));
    }

    public function edit($id)
    {
        $company_id = $this->current_company->id;
        // check this job is created by this company
        $job = $this->job
            ->where('company_id', $company_id)
            ->find($id);

        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "The job is not created by this company."]);
        }
        $job = $this->job->where('id', $id)->with([
            'subProfile' => function ($query) {
                $query->select(['id', 'name']);
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
        ])
            ->get()->toArray();
        if (!$job) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        $job  =  $job[0];
        return $this->navigationManagerService->loadView('company.job.edit', compact('job', 'qualifications', 'locations', 'sub_profiles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
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
            return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["success" => "Job is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not updated"]);
    }

    public function delete($id)
    {
        $company_id = $this->current_company->id;
        // check this job is created by this company
        $isDeleted = $this->job
            ->where('company_id', $company_id)
            ->find($id);

        if (!$isDeleted) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "The job is not created by this company."]);
        }

        // $isDeleted = $this->job->find($id);
        $isDeleted->locations()->detach();
        $isDeleted->qualifications()->detach();
        $isDeleted->delete();
        if (!$isDeleted) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Job is not found"]);
        }
        return $this->navigationManagerService->redirectRoute('company.job.index', [], 302, [], false, ["success" => "Job is deleted"]);
    }

    public function toggleFeatured($id, $is_featured)
    {
        $company_id = $this->current_company->id;
        $job = $this->job
            ->where('company_id', $company_id)
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
        $company_id = $this->current_company->id;
        $job = $this->job
            ->where('company_id', $company_id)
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
