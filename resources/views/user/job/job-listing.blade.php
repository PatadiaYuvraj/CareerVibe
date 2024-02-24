@extends('user.layout.app')
@section('title', 'Job List')
@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Browse Job</h1>
                        <p>Business plan draws on a wide range of knowledge from different business<br> disciplines.
                            Business draws on a wide range of different business .
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html">Home</a></li>
                        <li>Browse Job</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Find Job Area -->
    <section class="find-job job-list section">
        <div class="container ">
            <div class="single-head">
                <div class="row">
                    @forelse ($jobs as $job)
                        <!-- Single Job -->
                        <div class="single-job col-lg-4 col-md-6 col-12"
                            style="width: 45%; margin: 0 auto; margin-bottom: 20px; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease-in-out;">
                            <div class="job-content">
                                <h4>
                                    <a href="">
                                        {{ $job->subProfile->name }}
                                    </a>
                                </h4>
                                <ul class="d-flex">
                                    <li>
                                        <a href="{{ route('user.company.show', $job->company->id) }}">
                                            Offered By: {{ $job->company->name }}
                                        </a>
                                    </li>
                                </ul>
                                <ul>

                                    <li>
                                        @if ($job['min_salary'] >= 1000)
                                            <i class="bi bi-currency-rupee"></i>{{ $job['min_salary'] / 1000 }}k
                                            -
                                            <i class="bi bi-currency-rupee"></i>{{ $job['max_salary'] / 1000 }}k
                                        @else
                                            <i class="bi bi-currency-rupee"></i>{{ $job['min_salary'] }} -
                                            <i class="bi bi-currency-rupee"></i>{{ $job['max_salary'] }}
                                        @endif
                                    </li>



                                </ul>
                            </div>
                            <div class="job-button">
                                <ul>
                                    <li>
                                        @if ($job->is_saved)
                                            <a href="{{ route('user.job.unsaveJob', $job['id']) }}">
                                                <i class="bi bi-bookmark-check"></i> Saved
                                            </a>
                                        @else
                                            <a href="{{ route('user.job.saveJob', $job['id']) }}">
                                                <i class="bi bi-bookmark-plus"></i>
                                                Save Now
                                            </a>
                                        @endif
                                    </li>
                                    <li>
                                        <span>
                                            {{ Config::get('constants.job.experience_level')[$job->experience_level] }}
                                        </span>
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
                    @endforelse
                </div>

                @if (count($jobs) > 0 && $jobs->count() > 0)
                    @include('user.layout.pagination', [
                        'paginator' => $jobs->toArray()['links'],
                    ])
                @endif
            </div>
    </section>
    <!-- /End Find Job Area -->
@endsection
