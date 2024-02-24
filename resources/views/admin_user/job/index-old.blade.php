@extends('admin_user.layout.app')
@section('pageTitle', 'Available Jobs | ' . env('APP_NAME'))
@section('content')

    @php
        $locations = \App\Models\Location::all();
    @endphp
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Job
                    </span>

                    {{-- Filter by location --}}
                    {{-- <select class="form-select form-select-sm col- float-end" id="locationFilter">
                        <option value="">Filter by Location</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" {{ request()->location == $location->id ? 'selected' : '' }}>
                                {{ $location->city }} ({{ $location->state }})
                            </option>
                        @endforeach
                    </select> --}}

                    {{-- Filter --}}
                    <div class="dropdown float-end">
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="filterDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Filter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li>
                                <a class="dropdown-item
                                    {{ request()->type == '' ? 'active' : '' }}
                                "
                                    href="{{ route('admin_user.job.index') }}">
                                    All Jobs
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item
                                    {{ request()->type == 'active' ? 'active' : '' }}
                                "
                                    href="{{ route('admin_user.job.index', ['type' => 'active']) }}">
                                    Active Jobs
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item
                                    {{ request()->type == 'applied' ? 'active' : '' }}
                                "
                                    href="{{ route('admin_user.job.index', ['type' => 'applied']) }}">
                                    Applied Jobs
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item
                                    {{ request()->type == 'saved' ? 'active' : '' }}
                                "
                                    href="{{ route('admin_user.job.index', ['type' => 'saved']) }}">
                                    Saved Jobs
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item
                                    {{ request()->type == 'featured' ? 'active' : '' }}
                                "
                                    href="{{ route('admin_user.job.index', ['type' => 'featured']) }}">
                                    Featured Jobs
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item
                                    {{ request()->type == 'verified' ? 'active' : '' }}
                                "
                                    href="{{ route('admin_user.job.index', ['type' => 'verified']) }}">
                                    Verified Jobs
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Job Profile</th>
                                <th class="col-1">Vacancy</th>
                                <th>Salary</th>
                                <th class="col-1">Type</th>
                                <th class="col-1">Verified</th>
                                <th class="col-1">Featured</th>
                                <th class="col-1">Active</th>
                                <th class="col-1">Applied</th>
                                <th class="col-1">Saved</th>
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
                                        @if ($job->is_applied)
                                            <a href="{{ route('admin_user.job.unapply', $job['id']) }}"
                                                class="badge bg-success">
                                                Applied
                                            </a>
                                        @else
                                            <a href="{{ route('admin_user.job.apply', $job['id']) }}"
                                                class="badge bg-info">
                                                Apply Now
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($job->is_saved)
                                            <a href="{{ route('admin_user.job.unsaveJob', $job['id']) }}"
                                                class="badge bg-success">
                                                Saved
                                            </a>
                                        @else
                                            <a href="{{ route('admin_user.job.saveJob', $job['id']) }}"
                                                class="badge bg-info">
                                                Save Now
                                            </a>
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
