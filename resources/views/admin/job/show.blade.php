@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header ">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a wire:navigate href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a wire:navigate href="{{ route('admin.job.index') }}">Jobs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="col pt-3">
                        <h1 class="display-5">
                            {{ $job['sub_profile']['name'] }}
                        </h1>
                        <p class="lead position-relative">
                            <a wire:navigate
                                href="{{ route('admin.job.toggleVerified', [$job['id'], $job['is_verified']]) }}"
                                class="badge bg-{{ $job['is_verified'] ? 'success' : 'danger' }}">
                                {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }}
                            </a>
                        </p>
                        <p class="lead">Created At :
                            @if ($job['created_at'])
                                {{ date('d-m-Y', strtotime($job['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn" wire:navigate
                                href="{{ route('admin.job.edit', $job['id']) }}">Edit</a>
                        </p>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Company
                            </h5>
                            <h6 class="">
                                {{ $job['company']['name'] }}
                            </h6>
                            {{-- email --}}
                            <h6 class="">
                                {{ $job['company']['email'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Qualifications
                                </h5>
                                <h6 class="">
                                    @foreach ($job['qualifications'] as $qualification)
                                        <span class="badge bg-primary">{{ $qualification['name'] }}</span>
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Locations
                                </h5>
                                <h6 class="">
                                    @foreach ($job['locations'] as $location)
                                        <span class="badge bg-primary">{{ $location['city'] }}</span>
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Vacancies
                                </h5>
                                <h6 class="">
                                    {{ $job['vacancy'] }}
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Salary Package
                                </h5>
                                <h6 class="Laravel">
                                    @if ($job['min_salary'] >= 1000)
                                        {{ $job['min_salary'] / 1000 }}k -
                                        {{ $job['max_salary'] / 1000 }}k
                                    @else
                                        {{ $job['min_salary'] }} -
                                        {{ $job['max_salary'] }}
                                    @endif

                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Work Type
                                </h5>
                                <h6 class="">
                                    @foreach (Config::get('constants.job.work_type') as $key => $value)
                                        @if ($job['work_type'] == $key)
                                            {{ $value }}
                                        @endif
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Job Type
                                </h5>
                                <h6 class="">
                                    @foreach (Config::get('constants.job.job_type') as $key => $value)
                                        @if ($job['job_type'] == $key)
                                            {{ $value }}
                                        @endif
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Experience Level
                                </h5>
                                <h6 class="">
                                    @foreach (Config::get('constants.job.experience_level') as $key => $value)
                                        @if ($job['experience_level'] == $key)
                                            {{ $value }}
                                        @endif
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Experience Type
                                </h5>
                                <h6 class="">
                                    @foreach (Config::get('constants.job.experience_type') as $key => $value)
                                        @if ($job['experience_type'] == $key)
                                            {{ $value }}
                                        @endif
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Description
                            </h5>
                            <h6 class="">
                                {{ $job['description'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Responsibilities
                            </h5>
                            <h6 class="">
                                {{ $job['responsibility'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Benifits & Perks
                            </h5>
                            <h6 class="">
                                {{ $job['benifits_perks'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Other Benifits
                            </h5>
                            <h6 class="">
                                {{ $job['other_benifits'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Keywords
                            </h5>
                            <h6 class="">
                                {{ $job['keywords'] }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
