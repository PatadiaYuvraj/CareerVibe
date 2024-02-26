@extends('user.layout.app')

@section('title', $job->subProfile->name . ' - Job Details')

@php
    $featuredJobs = App\Models\Job::where('is_featured', 1)->orderBy('id', 'DESC')->limit(9)->get();
@endphp

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">
                            {{ $job->subProfile->name }} - Job Details
                        </h1>
                        <p>
                            Business plan draws on a wide range of knowledge from different business <br> disciplines.
                            Business draws on a wide range of different business .
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('user.job.index') }}">Job List</a></li>
                        <li>Job Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
                                    @if ($job['min_salary'] >= 1000)
                                        <i class="bi bi-currency-rupee"></i>
                                        <span class="">
                                            {{ $job['min_salary'] / 1000 }}k
                                        </span>
                                        -

                                        <i class="bi bi-currency-rupee me-0"></i>
                                        {{ $job['max_salary'] / 1000 }}k
                                    @else
                                        <i class="bi bi-currency-rupee me-0"></i>
                                        {{ $job['min_salary'] }} -
                                        <i class="bi bi-currency-rupee me-0"></i>
                                        {{ $job['max_salary'] }}
                                    @endif
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
                                        <i class="lni lni-map-marker text-muted"></i>
                                        {{ $job->company->address }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="job-details-body">
                            <h6 class="mb-3">
                                <i class="lni lni-briefcase"></i>
                                Job Description
                            </h6>
                            <p>
                                {!! nl2br($job->description) !!}
                            </p>
                            <h6 class="mb-3">
                                <i class="lni lni-list"></i>
                                Responsibilities
                            </h6>
                            <p>
                                {!! nl2br($job->responsibility) !!}
                            </p>
                            <h6 class="mb-3">
                                <i class="lni lni-graduation"></i>
                                Benifits & Perks
                            </h6>
                            <p>
                                {!! nl2br($job->benifits_perks) !!}
                            </p>
                            <h6 class="mb-3">
                                <i class="lni lni-graduation"></i>
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
                                    {{-- <li>
                                        <strong>Job Location:</strong> Willshire Glen
                                    </li> --}}
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
                                <h6 class="title">
                                    Job Qualifications
                                    ({{ $job->qualifications->count() }})
                                </h6>
                                <ul class="job-overview list-unstyled">
                                    @forelse ($job->qualifications as $qualification)
                                        <li>
                                            <i class="lni lni-graduation"></i>
                                            {{ $qualification->name }}
                                        </li>
                                    @empty
                                        <li>
                                            <i class="lni lni-graduation"></i>
                                            No Qualification Found
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar (Job Location) End -->
                        <!-- Sidebar (Job Location) Start -->
                        <div class="sidebar-widget">
                            <div class="inner">
                                <h6 class="title">
                                    Job Locations
                                    ({{ $job->locations->count() }})
                                </h6>
                                <ul class="job-overview list-unstyled">
                                    @forelse ($job->locations as $location)
                                        <li>
                                            <i class="lni lni-map-marker"></i>
                                            {{ $location->city }}
                                            ({{ $location->state }})
                                        </li>
                                    @empty
                                        <li>
                                            <i class="lni lni-map-marker"></i>
                                            No Location Found
                                        </li>
                                    @endforelse
                                </ul>
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

    <!-- Start About Area Done -->
    <section class="about-us section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10 col-12">
                    <div class="content-left wow fadeInLeft" data-wow-delay=".3s">
                        <div calss="row">
                            <div calss="col-lg-6 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img" src="{{ asset('front/images/about/small1.jpg') }}"
                                            alt="#" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img mt-50" src="{{ asset('front/images/about/small2.jpg') }}"
                                            alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div calss="col-lg-6 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img minus-margin"
                                            src="{{ asset('front/images/about/small3.jpg') }}" alt="#" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <!-- media body start -->
                                        <div class="media-body">
                                            <i class="lni lni-checkmark"></i>
                                            <h6 class="">Job alert!</h6>
                                            <p class="">104 new jobs are available in this week!</p>
                                        </div>
                                        <!-- media body start -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 col-12">
                    <!-- content-1 start -->
                    <div class="content-right wow fadeInRight" data-wow-delay=".5s">
                        <!-- Heading -->
                        <h2>
                            Help you to get the <br />
                            best job that fits you
                        </h2>
                        <!-- End Heading -->
                        <!-- Single List -->
                        <div class="single-list">
                            <i class="lni lni-grid-alt"></i>
                            <!-- List body start -->
                            <div class="list-bod">
                                <h5>
                                    #1 Jobs site in the world
                                </h5>
                                <p>
                                    Leverage agile frameworks to provide a robust synopsis for
                                    high level overviews.
                                </p>
                            </div>
                            <!-- List body start -->
                        </div>
                        <!-- End Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <i class="lni lni-search"></i>
                            <!-- List body start -->
                            <div class="list-bod">
                                <h5>
                                    Search for jobs
                                </h5>
                                <p>
                                    Iterative approaches to corporate strategy foster
                                    collaborative thinking to further the overall value
                                    proposition.
                                </p>
                            </div>
                            <!-- List body start -->
                        </div>
                        <!-- End Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <i class="lni lni-stats-up"></i>
                            <!-- List body start -->
                            <div class="list-bod">
                                <h5>
                                    Apply for jobs
                                </h5>
                                <p>
                                    Organically grow the holistic world view of disruptive
                                    innovation via workplace diversity and empowerment.
                                </p>
                            </div>
                            <!-- List body start -->
                        </div>
                        <!-- End Single List -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area -->

    <!-- Start Featured Job Area -->

    <!-- /End Featured Job Area -->

@endsection
