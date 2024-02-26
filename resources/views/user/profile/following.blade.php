@extends('user.profile.layout.app')

@section('title', 'Your Following')

@section('profile-breadcrumb-content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">
                            My Following
                        </h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Id beatae, doloremque<br />
                            doloribus, similique ullam quos tempore nemo,
                            voluptatibus placeat dignissimos ea.
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li>
                            <a href="{{ route('user.dashboard') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('user.profile.index') }}">Profile</a>
                        </li>
                        <li>My Following</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
@endsection

@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="job-items mb-3">
            @forelse ($users as $key => $user)
                <div class="manage-content mb-2 card py-2 px-4">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-3 col-md-3 col-12">
                            <h6>
                                {{ $user->followable->name }}
                            </h6>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <p>
                                <span class="time">
                                    {{ $user->followable->email }}
                                </span>
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            {{--  --}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>
                                <span class="time">
                                    @if ($user->followable_type == 'App\Models\User')
                                        User
                                    @endif
                                    @if ($user->followable_type == 'App\Models\Company')
                                        Company
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <div class="button">

                                @if ($user->followable_type == 'App\Models\User')
                                    <a href="{{ route('user.unfollow', $user->followable->id) }}"
                                        class="btn px-4 py-2">Following</a>
                                @endif
                                @if ($user->followable_type == 'App\Models\Company')
                                    <a href="{{ route('user.company.unfollow', $user->followable->id) }}"
                                        class="btn px-4 py-2">Following</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="manage-content mb-4 card py-4 px-4">
                    <div class="row text-center">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h6>
                                No following found.
                            </h6>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- Pagination -->
        @if (count($users) > 0 && $users->count() > 0)
            @include('user.layout.pagination', [
                'paginator' => $users->toArray()['links'],
            ])
        @endif
        <!-- End Pagination -->
    </div>
@endsection
