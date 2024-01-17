@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Job Profile
                    </span>
                    <a href="{{ route('admin.job-profile.create') }}" class="float-end btn btn-sm btn-primary">Add
                        profile</a>
                </div>
                <div class="card-body">
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th class="col-2">#</th>
                                <th class="col-2">Profile</th>
                                <th class="col-2">Available Jobs</th>
                                <th class="col-2">Created At</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($profiles as $profile)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin.job-profile.show', $profile['id']) }}">{{ $profile['profile'] }}
                                        </a>
                                    </td>
                                    <td>{{ $profile['jobs_count'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($profile['created_at'])) }}</td>
                                    <td class="btn-group">
                                        <a href="{{ route('admin.job-profile.edit', $profile['id']) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a href="{{ route('admin.job-profile.delete', $profile['id']) }}"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Job Profile Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {{ $profiles->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
