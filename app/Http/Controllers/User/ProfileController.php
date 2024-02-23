<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use App\Services\StorageManagerService;
use App\Services\MailableService;
use App\Services\NotifiableService;
use Illuminate\Support\Facades\Config;

class ProfileController extends Controller
{
    private User $user;
    private StorageManagerService $storageManagerService;
    private NotifiableService $notifiableService;
    private MailableService $mailableService;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(
        User $user,
        NotifiableService $notifiableService,
        MailableService $mailableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->user = $user;
        $this->notifiableService = $notifiableService;
        $this->mailableService = $mailableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->paginate = Config::get('constants.pagination');
    }

    public function index()
    {
        return $this->navigationManagerService->loadView('user.profile.index');
    }

    public function appliedJobs()
    {
        $appliedJobs = $this->authenticableService->getUser()->appliedJobs()->orderBy('id', 'DESC')->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.profile.applied-jobs', compact('appliedJobs'));
    }

    public function savedJobs()
    {
        $savedJobs = $this->authenticableService->getUser()->savedJobs()->orderBy('id', 'DESC')->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.profile.saved-jobs', compact('savedJobs'));
    }

    public function following()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $users = Follow::where('user_id', $user_id)
            ->with('followable')
            ->paginate($this->paginate);
        // dd($users);
        return $this->navigationManagerService->loadView('user.profile.following', compact('users'));
    }

    public function followers()
    {
        $id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $users = $user->followers()->paginate($this->paginate);
        // dd($users);
        return $this->navigationManagerService->loadView('user.profile.followers', compact('users'));
    }






    // 
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

    //
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
