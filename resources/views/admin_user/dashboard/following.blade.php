@extends('admin_user.layout.app')
@section('pageTitle', 'Yours Following | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Following
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Following</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $user->followable->name }}</td>
                                    <td>{{ $user->followable->email }}</td>
                                    <td>
                                        @if ($user->followable_type == 'App\Models\User')
                                            <span class="badge bg-primary">User</span>
                                        @endif
                                        @if ($user->followable_type == 'App\Models\Company')
                                            <span class="badge bg-success">Company</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->followable_type == 'App\Models\User')
                                            <a href="{{ route('admin_user.unfollow', $user->followable->id) }}"
                                                class="btn btn-success btn-sm">Following</a>
                                        @endif
                                        @if ($user->followable_type == 'App\Models\Company')
                                            <a href="{{ route('admin_user.company.unfollow', $user->followable->id) }}"
                                                class="btn btn-success btn-sm">Following</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No data found</td>
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
