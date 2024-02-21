@extends('admin_company.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Job
                    </span>
                    @if (auth()->guard('company')->user()->is_verified)
                        <a href="{{ route('admin_company.job.create') }}" class="float-end btn btn-sm btn-primary">Add Job</a>
                    @else
                        <button class="float-end btn btn-sm btn-primary" disabled>Add Job</button>
                    @endif

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
                                <th>Applied</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $job)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin_company.job.show', $job['id']) }}">
                                            {{ $job['subProfile']['name'] }}
                                        </a>
                                    </td>
                                    <td>{{ $job['vacancy'] }}</td>
                                    <td>
                                        @if ($job['min_salary'] >= 1000)
                                            {{ $job['min_salary'] / 1000 }}k -
                                            {{ $job['max_salary'] / 1000 }}k
                                        @else
                                            {{ $job['min_salary'] }} -
                                            {{ $job['max_salary'] }}
                                        @endif
                                    </td>
                                    <td>{{ $job['work_type'] }}</td>
                                    <td>
                                        <span class="btn-sm badge bg-{{ $job['is_verified'] ? 'success' : 'danger' }}">
                                            <i
                                                class="
                                            {{ $job['is_verified'] ? 'bi-toggle-on' : 'bi-toggle-off' }}
                                            "></i>
                                            {{-- {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }} --}}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin_company.job.toggleFeatured', [$job['id'], $job['is_featured']]) }}"
                                            class="badge bg-{{ $job['is_featured'] ? 'success' : 'danger' }}">
                                            <i
                                                class="
                                            {{ $job['is_featured'] ? 'bi-toggle-on' : 'bi-toggle-off' }}
                                            "></i>
                                            {{-- {{ $job['is_featured'] ? 'Featured' : 'Not Featured' }} --}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin_company.job.toggleActive', [$job['id'], $job['is_active']]) }}"
                                            class="badge bg-{{ $job['is_active'] ? 'success' : 'danger' }}">
                                            <i
                                                class="
                                            {{ $job['is_active'] ? 'bi-toggle-on' : 'bi-toggle-off' }}
                                            "></i>
                                            {{-- {{ $job['is_active'] ? 'Active' : 'Not Active' }} --}}
                                        </a>
                                    </td>
                                    <td>
                                        {{ count($job['applyByUsers']) }}
                                    </td>
                                    <td>

                                        <div class="d-flex btn-group">
                                            <a href="{{ route('admin_company.job.edit', $job['id']) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <a href="{{ route('admin_company.job.delete', $job['id']) }}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </div>
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
