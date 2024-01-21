@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
<main id="main" class="main">

    <section class="section dashboard">
        <div class="card">
            <div class="card-header pagetitle">
                <span class="h3 text-black">Users</span>

                <a href="{{ route('admin.user.create') }}" class="float-end btn btn-sm btn-primary">Add User</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Profile Image</th>
                            <th>Resume</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                @if ($user['profile_image_url'])
                                <a href="{{ $user['profile_image_url'] }}" target="_blank">View</a>
                                @else
                                <span class="text-danger">Not Available</span>
                                @endif
                            </td>
                            <td>
                                @if ($user['resume_pdf_url'])
                                <a href="{{ url($user['resume_pdf_url']) }}" target="_blank">View</a>
                                @else
                                <span class="text-danger">Not Available</span>
                                @endif
                            </td>
                            <td class="btn-group">
                                <a href="{{ route('admin.user.edit', $user['id']) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('admin.user.delete', $user['id']) }}" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan='6' class="text-center">No User Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="justify-content-center">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>

</main>
@endsection