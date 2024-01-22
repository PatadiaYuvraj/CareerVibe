@extends('user.layout.app')
@section('pageTitle', 'Dashboard | user')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Job
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $job)
                                <tr>
                                    <td>
                                        {{ $job['subProfile']['name'] }}
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
                                    {{-- apply for job --}}
                                    <td>
                                        @if ($job->is_applied)
                                            <a href="{{ route('user.job.unapply', $job['id']) }}"
                                                class="badge bg-success">Applied</a>
                                        @else
                                            <a href="{{ route('user.job.apply', $job['id']) }}" class="badge bg-info">Apply
                                                Now</a>
                                        @endif
                                        @if ($job->is_saved)
                                            <a href="{{ route('user.job.unsaveJob', $job['id']) }}"
                                                class="badge bg-success">Saved</a>
                                        @else
                                            <a href="{{ route('user.job.saveJob', $job['id']) }}"
                                                class="badge bg-info">Save Now</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No Job Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {{ $jobs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
