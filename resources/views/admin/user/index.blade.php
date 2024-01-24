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
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Profile Image</th>
                                <th>Resume</th>
                                <th>Applied Job</th>
                                <th>Saved Job</th>
                                <th>Followers</th>
                                <th>Following</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($user['profile_image_url'])
                                                <a href="{{ $user['profile_image_url'] }}" class="btn btn-sm btn-primary"
                                                    target="_blank">View</a>
                                                <form action="{{ route('admin.user.deleteProfileImage', $user['id']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this profile image?');">Delete</button>
                                                </form>
                                            @else
                                                <span class="text-danger">Not Available</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($user['resume_pdf_url'])
                                                <a href="{{ url($user['resume_pdf_url']) }}" class="btn btn-sm btn-primary"
                                                    target="_blank">View</a>
                                                <form action="{{ route('admin.user.deleteResumePdf', $user['id']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this resume?');">Delete</button>
                                                </form>
                                            @else
                                                <span class="text-danger">Not Available</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $user->applied_jobs_count }}</td>
                                    <td>{{ $user->saved_jobs_count }}</td>
                                    <td>{{ $user->followers_count }}</td>
                                    <td>{{ $user->following_count + $user->following_companies_count }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <form action="{{ route('admin.user.edit', $user['id']) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                                            </form>
                                            <form action="{{ route('admin.user.delete', $user['id']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                            </form>
                                        </div>
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
