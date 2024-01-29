<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Repository\AuthenticableRepository;
use App\Services\NavigationManagerService;
use Illuminate\Support\Facades\Config;

class JobController extends Controller
{
    private int $paginate;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableRepository $authenticableRepository;

    public function __construct(
        NavigationManagerService $navigationManagerService,
        AuthenticableRepository $authenticableRepository
    ) {
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableRepository = $authenticableRepository;
        $this->paginate = Config::get('constants.pagination');
    }

    public function index()
    {
        $user = $this->authenticableRepository->getUser();

        $jobs = Job::where('is_active', 1)
            ->with([
                'applyByUsers' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'savedByUsers' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ])
            ->paginate($this->paginate);
        foreach ($jobs as $job) {
            $job->is_applied = $job->applyByUsers->count() > 0;
            $job->is_saved = $job->savedByUsers->count() > 0;
        }
        return $this->navigationManagerService->loadView('user.job.index', compact('jobs'));
    }

    public function show($job_id)
    {
        $user_id = $this->authenticableRepository->getUser()->id;
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
        return $this->navigationManagerService->loadView('user.job.show', compact('job'));
    }

    public function appliedJobs()
    {
        $user_id = $this->authenticableRepository->getUser()->id;
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
        $user_id = $this->authenticableRepository->getUser()->id;
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
        $user_id = $this->authenticableRepository->getUser()->id;
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
        $user_id = $this->authenticableRepository->getUser()->id;
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
        $user_id = $this->authenticableRepository->getUser()->id;
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
        $user_id = $this->authenticableRepository->getUser()->id;
        $job = Job::find($job_id);
        $check = $job->savedByUsers()->where('user_id', $user_id)->exists();
        if (!$check) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You have not saved this job"]);
        }
        $job->savedByUsers()->detach($user_id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Job unsaved successfully"]);
    }
}
