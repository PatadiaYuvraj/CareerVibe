@extends('user.layout.app')

@section('title', 'Job List')

@php
    $featuredJobs = App\Models\Job::where('is_featured', 1)->orderBy('id', 'DESC')->limit(9)->get();
@endphp

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay wow fadeInDown">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Browse Job</h1>
                        <p>
                            Business plan draws on a wide range of knowledge from different business <br> disciplines.
                            Business draws on a wide range of different business .
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li>
                            Browse Job
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Find Job Area -->
    <section class="find-job job-list section wow fadeInUp">
        <div class="container ">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Hot Jobs</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Browse Recent Jobs
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="single-head">
                <div class="row">
                    @forelse ($jobs as $job)
                        <!-- Single Job -->
                        {{-- <div class="single-job col-lg-4 col-md-6 col-12"
                            style="width: 45%; margin: 0 auto; margin-bottom: 20px; padding: 20px; border: 1px solid #e0e0e0;   border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease-in-out;"> --}}
                        <div class="single-job col-lg-12 col-md-12 col-12"
                            style=" padding: 25px; border: 1px solid #e0e0e0;   border-radius: 10px;
                            ">
                            <div class="job-content">
                                <h4>
                                    <a href="
                                    {{ route('user.job.show', $job->id) }}">
                                        {{ $job->sub_profile_name }}
                                    </a>
                                </h4>
                                <ul class="d-flex">
                                    <li>
                                        <a href="{{ route('user.company.show', $job->company_id) }}">
                                            Offered By: {{ $job->company_name }}
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                    {{ Str::limit($job->description, 150, $end = '...') }}
                                </p>
                                <ul>
                                    <li>
                                        @if ($job->min_salary >= 1000)
                                            <i class="bi bi-currency-rupee"></i>{{ $job->min_salary / 1000 }}k
                                            -
                                            <i class="bi bi-currency-rupee"></i>{{ $job->max_salary / 1000 }}k
                                        @else
                                            <i class="bi bi-currency-rupee"></i>{{ $job->min_salary }} -
                                            <i class="bi bi-currency-rupee"></i>{{ $job->max_salary }}
                                        @endif
                                    </li>
                                    <li>
                                        <i class="lni lni-briefcase"></i>
                                        {{ Config::get('constants.job.work_type')[$job->work_type] }}
                                    </li>
                                    <li>
                                        <i class="lni lni-briefcase"></i>
                                        {{ Config::get('constants.job.job_type')[$job->job_type] }}
                                    </li>
                                    <li>
                                        <i class="lni lni-briefcase"></i>
                                        {{ Config::get('constants.job.experience_level')[$job->experience_level] }}
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        Qualifications:
                                    </li>
                                    @foreach ($job->qualifications as $item)
                                        <li>
                                            {{ $item->name }}
                                        </li>
                                    @endforeach
                                </ul>
                                <ul>
                                    <li>
                                        Locations:
                                    </li>
                                    @foreach ($job->locations as $item)
                                        <li>
                                            {{ $item->city }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="job-button">
                                <ul>
                                    <li>
                                        @if ($job->saved_by_me == 1)
                                            <a href="{{ route('user.job.unsaveJob', $job->id) }}">
                                                <i class="bi bi-bookmark-check"></i> Saved
                                            </a>
                                        @else
                                            <a href="{{ route('user.job.saveJob', $job->id) }}">
                                                <i class="bi bi-bookmark-plus"></i>
                                                Save Now
                                            </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($job->applied_by_me == 1)
                                            <a href="{{ route('user.job.unapply', $job->id) }}">
                                                <i class="bi bi-bookmark-check">
                                                </i>
                                                Applied
                                            </a>
                                        @else
                                            <a href="{{ route('user.job.apply', $job->id) }}">
                                                <i class="bi bi-check-circle">
                                                </i>
                                                Apply Now
                                            </a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Job -->
                    @empty
                        <div class="single-job mx-auto">
                            <div class="job-content">
                                <h4 class="text-center">
                                    <span class="text-danger">No Job Found</span>
                                </h4>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if (count($jobs) > 0 && $jobs->count() > 0)
                    @include('user.layout.pagination', [
                        'paginator' => $jobs->toArray()['links'],
                    ])
                @endif
            </div>
        </div>
    </section>
    <!-- /End Find Job Area -->

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
