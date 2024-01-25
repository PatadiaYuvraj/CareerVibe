@extends('company.layout.app')
@section('pageTitle', 'Your Followers | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Followers
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Remove Follower</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($followers as $company)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $company['name'] }}</td>
                                    <td>{{ $company['email'] }}</td>
                                    <td>
                                        <a href="{{ route('company.removeFollower', $company['id']) }}"
                                            class="btn btn-danger btn-sm">Remove Follower</a>
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
                        {{ $followers->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
