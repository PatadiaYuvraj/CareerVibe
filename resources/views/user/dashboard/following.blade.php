@extends('user.layout.app')
@section('pageTitle', 'Dashboard | Admin')
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
                            @foreach ($users as $user)
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
                                            <a href="{{ route('user.unfollow', $user->followable->id) }}"
                                                class="btn btn-success btn-sm">Following</a>
                                        @endif
                                        @if ($user->followable_type == 'App\Models\Company')
                                            <a href="{{ route('user.company.unfollow', $user->followable->id) }}"
                                                class="btn btn-success btn-sm">Following</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
