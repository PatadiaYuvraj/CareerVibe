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
                                <th>Following</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @if ($users)
                                @foreach ($users['following'] as $user)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>
                                            <a href="{{ route('user.unfollow', $user['id']) }}"
                                                class="btn btn-success btn-sm">
                                                Following
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($users['following_companies'] as $user)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>
                                            <a href="{{ route('user.company.unfollow', $user['id']) }}"
                                                class="btn btn-success btn-sm">Following</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan='6' class="text-center">No User Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>
@endsection
