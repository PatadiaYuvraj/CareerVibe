<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\Location;
use App\Models\ProfileCategory;
use App\Models\Qualification;
use App\Models\SubProfile;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{

    public function index()
    {
        $user = auth()->guard('user')->user();

        $jobs = Job::where('is_active', 1)->with([
            'applyByUsers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
            'savedByUsers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
        ])
            ->paginate(10);
        foreach ($jobs as $job) {
            $job->is_applied = $job->applyByUsers->count() > 0;
            $job->is_saved = $job->savedByUsers->count() > 0;
        }
        return view('user.job.index', compact('jobs'));
    }

    // public function show($job_id)
    // {
    //     $job = Job::find($job_id);

    //     dd($job);
    //     return view('user.job.show', compact('job'));
    // }

    public function appliedJobs()
    {
        $user_id = auth()->guard('user')->user()->id;
        $jobs = User::where('id', $user_id)->with([
            'appliedJobs' => function ($query) use ($user_id) {
                $query->with(['subProfile']);
            }
        ])->get()->toArray();
        $jobs = $jobs[0];
        return view('user.job.applied', compact('jobs'));
    }

    public function apply($job_id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $job = Job::find($job_id);
        // TODO: Send email to company to notify that user has applied for job
        // TODO: Send email to user to notify that user has applied for job
        // 


        $check = $job->applyByUsers()->where('user_id', $user_id)->exists();
        if ($check) {
            return back()->with('warning', 'You have already applied for this job');
        }
        $job->applyByUsers()->attach($user_id);
        return back()->with('success', 'Job applied successfully');
    }

    public function unapply($job_id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $job = Job::find($job_id);
        // TODO: Send email to company to notify that user has unapplied for job
        // TODO: Send email to user to notify that user has unapplied for job
        $check = $job->applyByUsers()->where('user_id', $user_id)->exists();
        if (!$check) {
            return back()->with('warning', 'You have not applied for this job');
        }
        $job->applyByUsers()->detach($user_id);
        return back()->with('success', 'Job unapplied successfully');
    }

    public function savedJobs()
    {
        $user_id = auth()->guard('user')->user()->id;
        $jobs = User::where('id', $user_id)->with([
            'savedJobs' => function ($query) use ($user_id) {
                $query->with(['subProfile']);
            }
        ])->get()->toArray();
        $jobs = $jobs[0];
        return view('user.job.saved', compact('jobs'));
    }

    public function saveJob($job_id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $job = Job::find($job_id);
        $check = $job->savedByUsers()->where('user_id', $user_id)->exists();
        // TODO: Send email to user to notify that user has saved job
        if ($check) {
            return back()->with('warning', 'You have already saved this job');
        }
        $job->savedByUsers()->attach($user_id);
        return back()->with('success', 'Job saved successfully');
    }

    public function unsaveJob($job_id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $job = Job::find($job_id);
        $check = $job->savedByUsers()->where('user_id', $user_id)->exists();
        // TODO: Send email to user to notify that user has unsaved job
        if (!$check) {
            return back()->with('warning', 'You have not saved this job');
        }
        $job->savedByUsers()->detach($user_id);
        return back()->with('success', 'Job unsaved successfully');
    }
}
