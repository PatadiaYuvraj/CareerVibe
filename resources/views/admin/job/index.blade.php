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
                    <a href="{{ route('admin.job.create') }}" class="float-end btn btn-sm btn-primary">Add Job</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table datatable table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job</th>
                                        <th>Job Profile</th>
                                        <th>Is Verified</th>
                                        <th>Is Featured</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $job['job_profile'] }}</td>
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
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
