@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Company</span>
                    <a href="{{ route('admin.company.create') }}" class="float-end btn btn-sm btn-primary">Add Company</a>
                </div>
                <div class="card-body">
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th class="col-2">Company Name</th>
                                <th class="col-2">Company Email</th>
                                <th class="col-2">Profile</th>
                                <th class="col-1">Jobs</th>
                                <th class="col-1">Verified</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($companies as $company)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.company.show', $company['id']) }}">
                                            {{ $company['name'] }}
                                        </a>
                                    </td>
                                    <td>{{ $company['email'] }}</td>
                                    <td>
                                        @if ($company['profile_image_url'])
                                            <a href="{{ $company['profile_image_url'] }}" target="_blank">View</a>
                                        @else
                                            <span class="text-danger">Not Available</span>
                                        @endif
                                    </td>
                                    <td>{{ $company['jobs_count'] }}</td>
                                    <td>
                                        <a href="{{ route('admin.company.toggleVerified', [$company['id'], $company['is_verified']]) }}"
                                            class=" badge bg-{{ $company['is_verified'] ? 'success' : 'danger' }}">
                                            {{ $company['is_verified'] ? 'Verified' : 'Not Verified' }}
                                        </a>
                                    </td>
                                    <td class="col-3">
                                        <div class="btn-group btn-group-sm d-flex">
                                            @if ($company['is_verified'])
                                                <a href="{{ route('admin.job.create', $company['id']) }}"
                                                    class="btn btn-sm btn-primary">Add Job</a>
                                            @endif
                                            <a href="{{ route('admin.company.edit', $company['id']) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <a href="{{ route('admin.company.delete', $company['id']) }}"
                                                class="btn btn-sm btn-primary">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100" class="text-center">No Company Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {{ $companies->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
