<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\Location;
use App\Models\ProfileCategory;
use App\Models\Qualification;
use App\Models\SubProfile;
use Illuminate\Http\Request;

class JobController extends Controller
{

    public function index()
    {
        $user = auth()->guard('user')->user();

        $jobs = Job::with([
            'applyByUsers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
            'savedByUsers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
        ])->paginate(10);

        // Mark applied and saved jobs for each job
        foreach ($jobs as $job) {
            $job->is_applied = $job->applyByUsers->count() > 0;
            $job->is_saved = $job->savedByUsers->count() > 0;
        }
        // dd($jobs);
        return view('user.job.index', compact('jobs'));
    }

    public function show($job_id)
    {
        $job = Job::find($job_id);

        dd($job);
        return view('user.job.show', compact('job'));
    }

    public function appliedJobs()
    {
        // $user_id = auth()->guard('user')->user()->id;
        $jobs = job::with(['applyByUsers' => function ($query) {
            $query->where('user_id', auth()->guard('user')->user()->id);
        }])->get()->toArray();
        dd($jobs);
        return view('user.job.applied', compact('jobs'));
    }

    public function apply($job_id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $job = Job::find($job_id);
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
        $jobs = job::with(['savedByUsers' => function ($query) {
            $query->where('user_id', auth()->guard('user')->user()->id);
        }])->get()->toArray();
        dd($jobs);
        return view('user.job.saved', compact('jobs'));
    }

    public function saveJob($job_id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $job = Job::find($job_id);
        $check = $job->savedByUsers()->where('user_id', $user_id)->exists();
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
        if (!$check) {
            return back()->with('warning', 'You have not saved this job');
        }
        $job->savedByUsers()->detach($user_id);
        return back()->with('success', 'Job unsaved successfully');
    }
}
