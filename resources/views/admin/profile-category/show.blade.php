@dd('Profile Category Show');Sub

{{-- @extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.job-profile.index') }}">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">

                    <div class="jumbotron">
                        <h1 class="display-5">{{ $profile['profile'] }}</h1>
                        <p class="lead">Created At :
                            @if ($profile['created_at'])
                                {{ date('d-m-Y', strtotime($profile['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn"
                                href="{{ route('admin.job-profile.edit', $profile['id']) }}">Edit</a>
                        </p>
                    </div>
                    <div class="card shadow-none">
                        <div class="card-header h3">Jobs({{ count($profile['jobs']) }})</div>
                        <div class="card-body">
                            <div class="row row-cols-3">
                                @forelse ($profile['jobs'] as $job)
                                    <div class="card-body shadow-none mt-3 col-4">
                                        <h6 class="card-subtitle mb-2  h5 text-decoration-underline">
                                            Offered by {{ $job['company']['name'] }}
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
@endsection --}}
