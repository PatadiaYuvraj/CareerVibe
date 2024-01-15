@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.location.index') }}">Locations</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">

                    <div class="jumbotron">
                        <h1 class="d-inline display-4">
                            {{ $location['city'] }},
                        </h1>
                        <h1 class="display-6 d-inline ">
                            {{ $location['state'] }}
                            ({{ $location['country'] }})
                        </h1>

                        <p class="lead">Created At :
                            @if ($location['created_at'])
                                {{ date('d-m-Y', strtotime($location['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn"
                                href="{{ route('admin.location.edit', $location['id']) }}">Edit</a>
                        </p>
                    </div>
                    <div class="card shadow-none">
                        <div class="card-header h3">Jobs</div>
                        <div class="card-body">
                            <div class="row row-cols-3">
                                @forelse ($location['jobs'] as $job)
                                    <div class="card-body shadow-none mt-3 col-4">
                                        <h6 class="card-subtitle mb-2  h5 text-decoration-underline">
                                            Offered by {{ $job['company']['name'] }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Job Title :
                                            {{ $job['profile']['profile'] }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Vacancy :
                                            {{ $job['vacancy'] }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Salary :
                                            {{ $job['min_salary'] . ' - ' . $job['max_salary'] }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Job is
                                            {{ $job['is_active'] ? 'Active' : 'Not Active' }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Job is
                                            {{ $job['is_featured'] ? 'Featured' : 'Not Featured' }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Job is
                                            {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Qualifications :
                                            @forelse ($job['qualifications'] as $qualification)
                                                <span
                                                    class="badge rounded-pill bg-primary">{{ $qualification['qualification'] }}</span>
                                            @empty
                                                {{ 'N/A' }}
                                            @endforelse
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Locations :
                                            @forelse ($job['locations'] as $location)
                                                <span class="badge rounded-pill bg-primary">{{ $location['city'] }}</span>
                                            @empty
                                                {{ 'N/A' }}
                                            @endforelse
                                        </h6>

                                    </div>
                                @empty
                                    <div class="card-body">
                                        <h5 class="card-title">No Jobs Available</h5>
                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
