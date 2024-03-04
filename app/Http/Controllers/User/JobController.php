<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    private int $paginate;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService
    ) {
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->paginate = Config::get('constants.pagination');
    }

    public function index(Request $request)
    {
        // $page = $request->input('page', 1);
        // $limit = $request->input('limit', 10);
        // $offset = ($page - 1) * $limit;
        // $authUserId = auth()->id();

        // $jobs = Job::with([
        //     'company',
        //     'locations',
        //     'qualifications',
        //     'subProfile',
        //     'applyByUsers' => function ($query) use ($authUserId) {
        //         $query->where('user_id', $authUserId);
        //     },
        //     'savedByUsers' => function ($query) use ($authUserId) {
        //         $query->where('user_id', $authUserId);
        //     },
        // ])
        //     ->offset($offset)
        //     ->limit($limit)
        //     ->get()->toArray();
        // dd($jobs);
        return $this->navigationManagerService->loadView('user.job.index');
    }

    // public function index(Request $request)
    // {
    //     return  $this->navigationManagerService->loadView('user.job.index');
    // }

    // get all jobs - ajax call

    // public function getAllJobs(Request $request)
    // {
    //     $user = $this->authenticableService->getUser();
    //     $filter = $request->input('filter', 'all');


    //     // type = all, applied, saved, verified, featured, active

    //     $jobs = Job::where('is_active', 1)
    //         ->with([
    //             'applyByUsers' => function ($query) use ($user) {
    //                 $query->where('user_id', $user->id);
    //             },
    //             'savedByUsers' => function ($query) use ($user) {
    //                 $query->where('user_id', $user->id);
    //             },
    //             'subProfile',
    //         ]);

    //     if ($filter == 'applied') {
    //         $jobs = $jobs->whereHas('applyByUsers', function ($query) use ($user) {
    //             $query->where('user_id', $user->id);
    //         });
    //     } else if ($filter == 'saved') {
    //         $jobs = $jobs->whereHas('savedByUsers', function ($query) use ($user) {
    //             $query->where('user_id', $user->id);
    //         });
    //     } else if ($filter == 'verified') {
    //         $jobs = $jobs->where('is_verified', 1);
    //     } else if ($filter == 'featured') {
    //         $jobs = $jobs->where('is_featured', 1);
    //     } else if ($filter == 'active') {
    //         $jobs = $jobs->where('is_active', 1);
    //     } else if ($filter == 'newest') {
    //         $jobs = $jobs->orderBy('created_at', 'desc');
    //     } else if ($filter == 'oldest') {
    //         $jobs = $jobs->orderBy('created_at', 'asc');
    //     } else if ($filter == 'salary_high') {
    //         $jobs = $jobs->orderBy('max_salary', 'desc');
    //     } else if ($filter == 'salary_low') {
    //         $jobs = $jobs->orderBy('max_salary', 'asc');
    //     } else if ($filter == 'remote') {
    //         $jobs = $jobs->where('work_type', 'REMOTE');
    //     } else if ($filter == 'onsite') {
    //         $jobs = $jobs->where('work_type', 'ONSITE');
    //     } else if ($filter == 'hybrid') {
    //         $jobs = $jobs->where('work_type', 'HYBRID');
    //     } else if ($filter == 'all') {
    //         $jobs = $jobs;
    //     } else {
    //         $jobs = $jobs;
    //     }

    //     $jobs = $jobs->paginate($this->paginate);

    //     foreach ($jobs as $job) {
    //         $job->is_applied = $job->applyByUsers->count() > 0;
    //         $job->is_saved = $job->savedByUsers->count() > 0;
    //     }
    //     return response()->json($jobs);
    // }

    public function loadMoreJobs(Request $request)
    {
        $page = $request->input('page', 1) ?? 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;


        $authUserId = auth()->id();
        $jobs = Job::select([
            'jobs.id',
            DB::raw("CONCAT('" . route('user.job.show', ['id' => ':id']) . "') as sub_profile_url"),
            DB::raw("CONCAT('" . route('user.company.show', ['id' => ':id']) . "') as company_url"),
            DB::raw("CONCAT('" . route('user.job.saveJob', ['id' => ':id']) . "') as save_job_url"),
            DB::raw("CONCAT('" . route('user.job.unsaveJob', ['id' => ':id']) . "') as unsave_job_url"),
            DB::raw("CONCAT('" . route('user.job.apply', ['id' => ':id']) . "') as apply_job_url"),
            DB::raw("CONCAT('" . route('user.job.unapply', ['id' => ':id']) . "') as unapply_job_url"),
            'jobs.min_salary',
            'jobs.max_salary',
            'jobs.experience_level',
            'jobs.description',
            'jobs.job_type',
            'jobs.work_type',
            'companies.id as company_id',
            'companies.name as company_name',
            'sub_profiles.name as sub_profile_name',
            'profile_categories.name as profile_category_name',
            DB::raw('IFNULL(applied_jobs.user_id, 0) as applied_by_me'),
            DB::raw('IFNULL(saved_jobs.user_id, 0) as saved_by_me'),
        ])
            ->leftJoin('companies', 'companies.id', '=', 'jobs.company_id')
            ->leftJoin('sub_profiles', 'sub_profiles.id', '=', 'jobs.sub_profile_id')
            // add profile category
            ->leftJoinSub(
                'select * from profile_categories',
                'profile_categories',
                function ($join) {
                    $join->on('profile_categories.id', '=', 'sub_profiles.profile_category_id');
                }
            )
            ->leftJoin('applied_jobs', function ($join) use ($authUserId) {
                $join->on('applied_jobs.job_id', '=', 'jobs.id')
                    ->where('applied_jobs.user_id', '=', $authUserId);
            })
            ->leftJoin('saved_jobs', function ($join) use ($authUserId) {
                $join->on('saved_jobs.job_id', '=', 'jobs.id')
                    ->where('saved_jobs.user_id', '=', $authUserId);
            })
            ->with([
                'qualifications' => function ($query) {
                    $query->select('qualifications.id', 'name');
                },
                'locations' => function ($query) {
                    $query->select('locations.id', 'city');
                }
            ])
            ->offset($offset)
            ->limit($limit)
            ->paginate($limit);

        return response()->json([
            'jobs' => $jobs->toArray()['data'],
            'has_more' => count($jobs) == $limit ? true : false,
            'page' => $page,
            'limit' => $limit,
            'offset' => $offset,
        ]);
    }


    public function show($job_id)
    {
        $user_id = $this->authenticableService->getUser()->id;
        $job = Job::where("id", $job_id)
            ->with([
                'company',
                'locations',
                'qualifications',
                'subProfile',
                'applyByUsers' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                },
                'savedByUsers' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                },
            ])
            ->first();

        $job->is_applied = $job->applyByUsers->count() > 0;
        $job->is_saved = $job->savedByUsers->count() > 0;

        return $this->navigationManagerService->loadView('user.job.show', compact('job'));
    }

    public function appliedJobs()
    {
        $user_id = $this->authenticableService->getUser()->id;
        $jobs = User::where('id', $user_id)->with([
            'appliedJobs' => function ($query) {
                $query->with(['subProfile']);
            }
        ])->get()->toArray();
        $jobs = $jobs[0];
        return $this->navigationManagerService->loadView('user.job.applied', compact('jobs'));
    }

    public function apply($job_id)
    {
        $user_id = $this->authenticableService->getUser()->id;
        $job = Job::find($job_id);

        $check = $job->applyByUsers()->where('user_id', $user_id)->exists();
        if ($check) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You have already applied for this job"]);
        }
        $job->applyByUsers()->attach($user_id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job applied successfully"]);
    }

    public function unapply($job_id)
    {
        $user_id = $this->authenticableService->getUser()->id;
        $job = Job::find($job_id);
        $check = $job->applyByUsers()->where('user_id', $user_id)->exists();
        if (!$check) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You have not applied for this job"]);
        }
        $job->applyByUsers()->detach($user_id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job unapplied successfully"]);
    }

    public function savedJobs()
    {
        $user_id = $this->authenticableService->getUser()->id;
        $jobs = User::where('id', $user_id)->with([
            'savedJobs' => function ($query) use ($user_id) {
                $query->with(['subProfile']);
            }
        ])->get()->toArray();
        $jobs = $jobs[0];
        return $this->navigationManagerService->loadView('user.job.saved', compact('jobs'));
    }

    public function saveJob($job_id)
    {
        $user_id = $this->authenticableService->getUser()->id;
        $job = Job::find($job_id);
        $check = $job->savedByUsers()->where('user_id', $user_id)->exists();
        if ($check) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You have already saved this job"]);
        }
        $job->savedByUsers()->attach($user_id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job saved successfully"]);
    }

    public function unsaveJob($job_id)
    {
        $user_id = $this->authenticableService->getUser()->id;
        $job = Job::find($job_id);
        $check = $job->savedByUsers()->where('user_id', $user_id)->exists();
        if (!$check) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You have not saved this job"]);
        }
        $job->savedByUsers()->detach($user_id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job unsaved successfully"]);
    }
}
