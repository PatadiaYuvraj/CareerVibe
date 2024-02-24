@extends('user.layout.app')
@section('title', 'Job List')
{{-- @dd($job) --}}
@section('content')
    <!-- Start Breadcrumbs -->
    {{-- <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Job Details</h1>
                        <p>Business plan draws on a wide range of knowledge from different business<br> disciplines.
                            Business draws on a wide range of different business .</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="news-standard.html">Blog</a></li>
                        <li>Job Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Breadcrumbs -->

    <!-- Start Job Details -->
    <div class="job-details section">
        <div class="container">
            <div class="row mb-n5">
                <!-- Job List Details Start -->
                <div class="col-lg-8 col-12">
                    <div class="job-details-inner">
                        <div class="job-details-head row mx-0">
                            <div class="salary-type col-auto order-sm-3">
                                <span class="salary-range">
                                    {{ $job->min_salary }} - {{ $job->max_salary }}
                                </span>
                                <span class="badge badge-success">
                                    {{ Config::get('constants.job.job_type')[$job['job_type']] }}
                                </span>
                            </div>
                            <div class="content col">
                                <h5 class="title">
                                    <a href="javascript:void(0)">
                                        {{ $job->subProfile->name }}</a>
                                </h5>
                                <ul class="meta">
                                    <li>
                                        <strong class="text-primary">
                                            <a href="javascript:void(0)">
                                                {{ $job->company->name }}
                                            </a>
                                        </strong>
                                    </li>
                                    <li>
                                        <i class="lni lni-map-marker"></i>
                                        {{ $job->company->address }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="job-details-body">
                            <h6 class="mb-3">
                                Job Description
                            </h6>
                            <p>
                                {!! nl2br($job->description) !!}
                            </p>
                            <h6 class="mb-3">
                                Responsibilities
                            </h6>
                            <p>
                                {!! nl2br($job->responsibility) !!}
                            </p>
                            <h6 class="mb-3">
                                Benifits & Perks
                            </h6>
                            <p>
                                {!! nl2br($job->benifits_perks) !!}
                            </p>
                            <h6 class="mb-3">
                                Other Benifits
                            </h6>
                            <p>
                                {!! nl2br($job->other_benifits) !!}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Job List Details End -->
                <!-- Job Sidebar Wrap Start -->
                <div class="col-lg-4 col-12">
                    <div class="job-details-sidebar">
                        <!-- Sidebar (Apply Buttons) Start -->
                        <div class="sidebar-widget">
                            <div class="inner">
                                <div class="row m-n2 button g-2">
                                    <div class="col-lg-12 col-sm-auto col-12">
                                        @if ($job->is_saved)
                                            <a href="{{ route('user.job.unsaveJob', $job['id']) }}" class="d-block btn">
                                                <i class="bi bi-bookmark-fill">
                                                    Saved
                                                </i>
                                            </a>
                                        @else
                                            <a href="{{ route('user.job.saveJob', $job['id']) }}" class="d-block btn">
                                                <i class="bi bi-bookmark">
                                                    Save Now
                                                </i>
                                            </a>
                                        @endif

                                    </div>
                                    <div class="col-lg-12 col-sm-auto col-12">
                                        @if ($job->is_applied)
                                            <a href="{{ route('user.job.unapply', $job['id']) }}" class="d-block btn">
                                                <i class="bi bi-check-circle-fill">
                                                    Applied
                                                </i>
                                            </a>
                                        @else
                                            <a href="{{ route('user.job.apply', $job['id']) }}" class="d-block btn">
                                                <i class="bi bi-check-circle">
                                                    Apply Now
                                                </i>

                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar (Apply Buttons) End -->
                        <!-- Sidebar (Job Overview) Start -->
                        <div class="sidebar-widget">
                            <div class="inner">
                                <h6 class="title">Job Overview</h6>
                                <ul class="job-overview list-unstyled">
                                    <li>
                                        <strong>Published on:</strong>
                                        {{ $job->created_at->format('d M, Y') }}
                                    </li>
                                    <li>
                                        <strong>Vacancy:</strong>
                                        {{ $job->vacancy }}
                                    </li>
                                    <li>
                                        <strong>Employment Status:</strong>
                                        {{ Config::get('constants.job.job_type')[$job['job_type']] }}
                                    </li>
                                    <li>
                                        <strong>Experience:</strong>
                                        {{ Config::get('constants.job.experience_type')[$job->experience_type] }}
                                    </li>
                                    <li>
                                        {{-- <strong>Job Location:</strong> Willshire Glen --}}
                                    </li>
                                    <li>
                                        <strong>Salary:</strong>
                                        {{ $job->min_salary }} - {{ $job->max_salary }}
                                    </li>
                                    <li>
                                        <strong>Application Deadline:</strong> Dec 15, 2023
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar (Job Overview) End -->

                        <!-- Sidebar (Job Location) Start -->
                        <div class="sidebar-widget">
                            <div class="inner">
                                <h6 class="title">Job Locations</h6>
                                {{-- <div class="mapouter">
                                    <div class="gmap_canvas"><iframe width="100%" height="300" id="gmap_canvas"
                                            src="https://maps.google.com/maps?q=New%20York&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a
                                            href="https://123movies-to.com/">123movies old
                                            site</a>
                                        <style>
                                            .mapouter {
                                                position: relative;
                                                text-align: right;
                                                height: 300px;
                                                width: 100%;
                                            }

                                            .gmap_canvas {
                                                overflow: hidden;
                                                background: none !important;
                                                height: 300px;
                                                width: 100%;
                                            }
                                        </style><a href="https://maps-google.github.io/embed-google-map/">embed google
                                            map</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- Sidebar (Job Location) End -->

                        <!-- Sidebar (Job Location) Start -->
                        <div class="sidebar-widget">
                            <div class="inner">
                                <h6 class="title">Job Qualifications</h6>
                                {{-- <div class="mapouter">
                                    <div class="gmap_canvas"><iframe width="100%" height="300" id="gmap_canvas"
                                            src="https://maps.google.com/maps?q=New%20York&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a
                                            href="https://123movies-to.com/">123movies old
                                            site</a>
                                        <style>
                                            .mapouter {
                                                position: relative;
                                                text-align: right;
                                                height: 300px;
                                                width: 100%;
                                            }

                                            .gmap_canvas {
                                                overflow: hidden;
                                                background: none !important;
                                                height: 300px;
                                                width: 100%;
                                            }
                                        </style><a href="https://maps-google.github.io/embed-google-map/">embed google
                                            map</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- Sidebar (Job Location) End -->
                    </div>
                </div>
                <!-- Job Sidebar Wrap End -->

            </div>
        </div>
    </div>
    <!-- End Job Details -->
@endsection
