@extends('admin_user.layout.app')
@section('pageTitle', 'List of Users | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        @php
            $authUser = Auth::guard('user')->user();
            $authUserFollows = [];
            foreach ($authUser['following'] as $follow) {
                $authUserFollows[] = $follow['id'];
            }
        @endphp
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Users</span>
                </div>
                <div class="card-body">
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th class="col-1">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="col-1">Followers</th>
                                <th class="col-1">Following</th>
                                <th class="col-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ count($user['followers']) }}</td>
                                    <td>{{ count($user['following']) + count($user['followingCompanies']) }}</td>

                                    <td>
                                        @if (in_array($user['id'], $authUserFollows))
                                            <a href="{{ route('admin_user.unfollow', $user['id']) }}"
                                                class="btn btn-sm btn-danger">
                                                Following
                                            </a>
                                        @else
                                            <a href="{{ route('admin_user.follow', $user['id']) }}"
                                                class="btn btn-sm btn-primary">
                                                Follow
                                            </a>
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
