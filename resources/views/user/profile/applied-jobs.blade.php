@extends('user.profile.layout.app')
@section('title', 'Your Applied Jobs')

@section('profile-breadcrumb-content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">
                            Your Applied Jobs
                        </h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Id beatae, doloremque<br />
                            doloribus, similique ullam quos tempore nemo,
                            voluptatibus placeat dignissimos ea.
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li>
                            <a href="{{ route('user.profile.index') }}">Profile</a>
                        </li>
                        <li>Applied Jobs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
@endsection

@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="job-items mb-3">
            @forelse ($appliedJobs as $key =>$job)
                <div class="manage-content mb-2 card py-2 px-4">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-5 col-md-5 col-12">
                            <h6>
                                {{ $job->subProfile->name }}
                            </h6>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>
                                <span class="time">
                                    {{ Config::get('constants.job.job_type')[$job->job_type] }}
                                </span>
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <p class="location">
                                {{ $job->work_type }}
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <div class="button">
                                <a href="{{ route('user.job.unapply', $job['id']) }}" class="btn px-4 py-2">
                                    Unapply
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="manage-content mb-4 card py-4 px-4">
                    <div class="row text-center">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h6>
                                No applied jobs found.
                            </h6>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- Pagination -->
        @if (count($appliedJobs) > 0 && $appliedJobs->count() > 0)
            @include('user.layout.pagination', [
                'paginator' => $appliedJobs->toArray()['links'],
            ])
        @endif
        <!-- End Pagination -->
    </div>
@endsection
