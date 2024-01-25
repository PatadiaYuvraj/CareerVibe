@extends('user.layout.app')
@section('pageTitle', 'Your Saved Jobs | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Saved Job
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Job Profile</th>
                                <th>Job Vacancy</th>
                                <th>Salary</th>
                                <th>Work Type</th>
                                <th>Verified</th>
                                <th>Featured</th>
                                <th>Active</th>
                                <th>Unsave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs['saved_jobs'] as $job)
                                <tr>
                                    <td>
                                        {{ $job['sub_profile']['name'] }}
                                    </td>
                                    <td>{{ $job['vacancy'] }}</td>
                                    <td>
                                        {{ $job['min_salary'] }} -
                                        {{ $job['max_salary'] }}
                                    </td>
                                    <td>{{ $job['work_type'] }}</td>
                                    <td>
                                        <a class="badge bg-{{ $job['is_verified'] ? 'success' : 'danger' }}">
                                            {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="badge bg-{{ $job['is_featured'] ? 'success' : 'danger' }}">
                                            {{ $job['is_featured'] ? 'Featured' : 'Not Featured' }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="badge bg-{{ $job['is_active'] ? 'success' : 'danger' }}">
                                            {{ $job['is_active'] ? 'Active' : 'Not Active' }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.job.unsaveJob', $job['id']) }}"
                                            class="btn btn-danger btn-sm">
                                            Unsave
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No Saved Job Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- <div class="justify-content-center">
                        {{ $jobs->links('pagination::bootstrap-5') }}
                    </div> --}}
                </div>
            </div>
        </section>
    </main>
@endsection
