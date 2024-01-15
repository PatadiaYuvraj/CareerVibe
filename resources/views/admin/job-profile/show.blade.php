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
                            <li class="breadcrumb-item"><a href="{{ route('admin.job-profile.index') }}">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                    {{-- <a href="{{ route('admin.job-profile.index') }}" class="float-end btn btn-sm btn-primary">Back</a> --}}
                </div>
                <div class="card-body">
                    {{--  --}}

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

                    {{-- <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company</th>
                                        <th>Job Profile</th>
                                        <th>Is Verified</th>
                                        <th>Is Featured</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($profile['jobs'] as $job)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $job['company']['name'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.job.toggleVerified', [$job['id'], $job['is_verified']]) }}"
                                                    class="badge bg-{{ $job['is_verified'] ? 'success' : 'danger' }}">
                                                    {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.job.toggleFeatured', [$job['id'], $job['is_featured']]) }}"
                                                    class="badge bg-{{ $job['is_featured'] ? 'success' : 'danger' }}">
                                                    {{ $job['is_featured'] ? 'Featured' : 'Not Featured' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.job.toggleActive', [$job['id'], $job['is_active']]) }}"
                                                    class="badge bg-{{ $job['is_active'] ? 'success' : 'danger' }}">
                                                    {{ $job['is_active'] ? 'Active' : 'Not Active' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.job.edit', $job['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.job.delete', $job['id']) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    <div class="card shadow-none">
                        <div class="card-header h3">Jobs</div>
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
                                        {{-- <a href="{{ route('admin.job.edit', $job['id']) }}" class="card-link">Edit</a>
                                        <a href="{{ route('admin.job.delete', $job['id']) }}" class="card-link">Delete</a> --}}
                                    </div>
                                @empty
                                    <div class="card-body">
                                        <h5 class="card-title">No Jobs Available</h5>
                                    </div>
                                @endforelse
                                {{--  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
