@extends('user.layout.app')
@section('title', 'Job List')

@section('content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Job List</h1>
                        <p>Business plan draws on a wide range of knowledge from different business<br> disciplines.
                            Business draws on a wide range of different business .</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="news-standard.html">Blog</a></li>
                        <li>Job List</li>
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
                        <div class="single-job mx-auto">
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
                    @endforelse
                </div>

                <div class="pagination justify-content-center">
                    <nav>
                        <ul class="d-flex justify-content-center">


                            {{-- {{ $jobs->links('pagination::bootstrap-5') }} --}}
                            {{-- <li class="page-item">

                                @if ($jobs->onFirstPage())
                                    <a class="page-link" href="javascript:void(0)" id="firstPage">First</a>
                                @else
                                    <a class="page-link" href="{{ $jobs->url(1) }}" id="firstPage">First</a>
                                @endif
                            </li>

                            <li class="page-item">
                                @if ($jobs->onFirstPage())
                                    <a class="page-link" href="javascript:void(0)" id="prevPage">
                                        Previous
                                    </a>
                                @else
                                    <a class="page-link" href="{{ $jobs->previousPageUrl() }}" id="prevPage">
                                        Previous
                                    </a>
                                @endif
                            </li>


                            <li class="page-item">
                                @if ($jobs->hasMorePages())
                                    <a class="page-link" href="{{ $jobs->nextPageUrl() }}" id="nextPage">
                                        Next
                                    </a>
                                @else
                                    <a class="page-link" href="javascript:void(0)" id="nextPage">
                                        Next
                                    </a>
                                @endif
                            </li>

                            <li class="page-item">
                                @if ($jobs->hasMorePages())
                                    <a class="page-link" href="{{ $jobs->url($jobs->lastPage()) }}"
                                        id="lastPage">Last</a>
                                @else
                                    <a class="page-link" href="javascript:void(0)" id="lastPage">Last</a>
                                @endif
                            </li> --}}

                        </ul>
                    </nav>

                </div>
            </div>
    </section>
    <!-- /End Find Job Area -->
@endsection
