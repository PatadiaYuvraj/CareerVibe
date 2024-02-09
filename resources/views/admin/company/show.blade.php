@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a wire:navigate href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a wire:navigate
                                    href="{{ route('admin.company.index') }}">Companies</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                    {{-- <a href="{{ route('admin.company.index') }}" class="float-end btn btn-sm btn-primary">Back</a> --}}
                </div>
                <div class="card-body">
                    {{--  --}}

                    <div class="jumbotron">
                        <h1 class="display-5">
                            {{ $company['name'] }}
                        </h1>
                        <p class="lead position-relative">
                            <a href="{{ route('admin.company.toggleVerified', [$company['id'], $company['is_verified']]) }}"
                                class="badge bg-{{ $company['is_verified'] ? 'success' : 'danger' }}">
                                {{ $company['is_verified'] ? 'Verified' : 'Not Verified' }}
                            </a>
                        </p>
                        <p class="lead">Created At :
                            @if ($company['created_at'])
                                {{ date('d-m-Y', strtotime($company['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn"
                                href="{{ route('admin.company.edit', $company['id']) }}">Edit</a>
                        </p>
                    </div>


                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Job Profile</th>
                                    <th>Vacancy</th>
                                    <th>Salary</th>
                                    <th>Is Verified</th>
                                    <th>Is Featured</th>
                                    <th>Is Active</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company['jobs'] as $job)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $job['sub_profile']['name'] }}</td>
                                        <td>{{ $job['vacancy'] }}</td>
                                        <td>{{ $job['min_salary'] . ' - ' . $job['min_salary'] }}</td>
                                        <td>
                                            <a wire:navigate
                                                href="{{ route('admin.job.toggleVerified', [$job['id'], $job['is_verified']]) }}"
                                                class="badge bg-{{ $job['is_verified'] ? 'success' : 'danger' }}">
                                                {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a wire:navigate
                                                href="{{ route('admin.job.toggleFeatured', [$job['id'], $job['is_featured']]) }}"
                                                class="badge bg-{{ $job['is_featured'] ? 'success' : 'danger' }}">
                                                {{ $job['is_featured'] ? 'Featured' : 'Not Featured' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a wire:navigate
                                                href="{{ route('admin.job.toggleActive', [$job['id'], $job['is_active']]) }}"
                                                class="badge bg-{{ $job['is_active'] ? 'success' : 'danger' }}">
                                                {{ $job['is_active'] ? 'Active' : 'Not Active' }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
