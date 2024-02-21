<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

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

    public function index_old(Request $request)
    {
        $user = $this->authenticableService->getUser();
        $type = $request->input('type', 'all');

        // type = all, applied, saved, verified, featured, active

        $jobs = Job::where('is_active', 1)
            ->with([
                'applyByUsers' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'savedByUsers' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ]);

        if ($type == 'applied') {
            $jobs = $jobs->whereHas('applyByUsers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } else if ($type == 'saved') {
            $jobs = $jobs->whereHas('savedByUsers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } else if ($type == 'verified') {
            $jobs = $jobs->where('is_verified', 1);
        } else if ($type == 'featured') {
            $jobs = $jobs->where('is_featured', 1);
        }

        $jobs = $jobs->paginate($this->paginate);

        foreach ($jobs as $job) {
            $job->is_applied = $job->applyByUsers->count() > 0;
            $job->is_saved = $job->savedByUsers->count() > 0;
        }

        return $this->navigationManagerService->loadView('admin_user.job.index', compact('jobs'));

        // $jobs = Job::where('is_active', 1)
        //     ->with([
        //         'applyByUsers' => function ($query) use ($user) {
        //             $query->where('user_id', $user->id);
        //         },
        //         'savedByUsers' => function ($query) use ($user) {
        //             $query->where('user_id', $user->id);
        //         },
        //     ])
        //     ->paginate($this->paginate);


        // foreach ($jobs as $job) {
        //     $job->is_applied = $job->applyByUsers->count() > 0;
        //     $job->is_saved = $job->savedByUsers->count() > 0;
        // }
        // return $this->navigationManagerService->loadView('admin_user.job.index', compact('jobs'));
    }

    public function index(Request $request)
    {
        return  $this->navigationManagerService->loadView('admin_user.job.index');
    }

    // get all jobs - ajax call

    public function getAllJobs(Request $request)
    {
        $user = $this->authenticableService->getUser();
        $filter = $request->input('filter', 'all');


        // type = all, applied, saved, verified, featured, active

        $jobs = Job::where('is_active', 1)
            ->with([
                'applyByUsers' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'savedByUsers' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'subProfile',
            ]);

        if ($filter == 'applied') {
            $jobs = $jobs->whereHas('applyByUsers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } else if ($filter == 'saved') {
            $jobs = $jobs->whereHas('savedByUsers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } else if ($filter == 'verified') {
            $jobs = $jobs->where('is_verified', 1);
        } else if ($filter == 'featured') {
            $jobs = $jobs->where('is_featured', 1);
        } else if ($filter == 'active') {
            $jobs = $jobs->where('is_active', 1);
        } else if ($filter == 'newest') {
            $jobs = $jobs->orderBy('created_at', 'desc');
        } else if ($filter == 'oldest') {
            $jobs = $jobs->orderBy('created_at', 'asc');
        } else if ($filter == 'salary_high') {
            $jobs = $jobs->orderBy('max_salary', 'desc');
        } else if ($filter == 'salary_low') {
            $jobs = $jobs->orderBy('max_salary', 'asc');
        } else if ($filter == 'remote') {
            $jobs = $jobs->where('work_type', 'REMOTE');
        } else if ($filter == 'onsite') {
            $jobs = $jobs->where('work_type', 'ONSITE');
        } else if ($filter == 'hybrid') {
            $jobs = $jobs->where('work_type', 'HYBRID');
        } else if ($filter == 'all') {
            $jobs = $jobs;
        } else {
            $jobs = $jobs;
        }

        $jobs = $jobs->paginate($this->paginate);

        foreach ($jobs as $job) {
            $job->is_applied = $job->applyByUsers->count() > 0;
            $job->is_saved = $job->savedByUsers->count() > 0;
        }
        return response()->json($jobs);
    }


    public function show($job_id)
    {
        $user_id = $this->authenticableService->getUser()->id;
        $job = Job::find($job_id)
            ->with([
                'company',
                'locations',
                'qualifications',
                'subProfile',
                'applyByUsers' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                },
            ])
            ->first()
            ->toArray();
        return $this->navigationManagerService->loadView('admin_user.job.show', compact('job'));
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
        return $this->navigationManagerService->loadView('admin_user.job.applied', compact('jobs'));
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
        return $this->navigationManagerService->loadView('admin_user.job.saved', compact('jobs'));
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
