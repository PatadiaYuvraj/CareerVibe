@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Job Profile</th>
                                <th>Job Vacancy</th>
                                <th>Salary Range</th>
                                <th>Work Type</th>
                                <th>Is Verified</th>
                                <th>Is Featured</th>
                                <th>Is Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $job)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.job.show', $job['id']) }}">
                                            {{ $job['profile']['profile'] }}
                                        </a>
                                    </td>
                                    <td>{{ $job['vacancy'] }}</td>
                                    <td>
                                        {{ $job['min_salary'] }} -
                                        {{ $job['max_salary'] }}
                                    </td>
                                    <td>{{ $job['work_type'] }}</td>
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
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Job Found</td>
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
