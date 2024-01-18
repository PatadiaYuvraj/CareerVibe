@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        {{-- @dd ($subProfiles[0]->profileCategory); --}}
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Sub Profile
                    </span>
                    <a href="{{ route('admin.sub-profile.create') }}" class="float-end btn btn-sm btn-primary">
                        Add sub profile
                    </a>
                </div>
                <div class="card-body">
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th class="col-2">Name</th>
                                <th class="col-2">Category</th>
                                <th class="col-1">Jobs</th>
                                <th class="col-2">Action</th>

                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($subProfiles as $subProfile)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.sub-profile.show', $subProfile['id']) }}">{{ $subProfile['name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('admin.profile-category.show', $subProfile->profileCategory['id']) }}">
                                            {{ $subProfile->profileCategory['name'] }}
                                        </a>
                                    </td>
                                    <td>{{ $subProfile['jobs_count'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.sub-profile.edit', $subProfile['id']) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <a href="{{ route('admin.sub-profile.delete', $subProfile['id']) }}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Sub Profile Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {{ $subProfiles->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
