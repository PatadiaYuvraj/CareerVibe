@extends('user.layout.app')
@section('pageTitle', 'List of Companies | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        All Companies
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">Company Name</th>
                                <th scope="col">Company Email</th>
                                <th scope="col">Followers</th>
                                <th scope="col">Follow</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->followers->count() }}</td>
                                    <td>
                                        @if ($company->followers->contains(Auth::guard('user')->user()->id))
                                            <a href="{{ route('user.company.unfollow', $company->id) }}"
                                                class="btn btn-sm btn-danger">
                                                Following
                                            </a>
                                        @else
                                            <a href="{{ route('user.company.follow', $company->id) }}"
                                                class="btn btn-sm btn-primary">
                                                Follow
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No Company Found</td>
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
