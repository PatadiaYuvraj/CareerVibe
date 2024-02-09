@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        {{-- @dd ($profileCategory) --}}
        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a wire:navigate href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a wire:navigate
                                    href="{{ route('admin.profile-category.index') }}">Profile</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">

                    <div class="jumbotron">
                        <h1 class="display-5">{{ $profileCategory['name'] }}</h1>
                        <p class="lead">Created At :
                            @if ($profileCategory['created_at'])
                                {{ date('d-m-Y', strtotime($profileCategory['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn" wire:navigate
                                href="{{ route('admin.profile-category.edit', $profileCategory['id']) }}">Edit</a>
                        </p>
                    </div>
                    <div class="card shadow-none">
                        <div class="card-header h3">
                            Sub Profiles
                            ({{ count($profileCategory['sub_profiles']) }})</div>
                        <div class="card-body">
                            <div class="row row-cols-3">
                                @forelse ($profileCategory['sub_profiles'] as $sub_profile)
                                    <div class="card-body shadow-none mt-3 col-4">
                                        <h6 class="card-subtitle mb-2 h5">
                                            {{ $sub_profile['name'] }}
                                        </h6>
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            No. of Jobs Available
                                            {{ $sub_profile['jobs_count'] }}
                                        </h6>
                                    </div>
                                @empty
                                    <div class="card-body">
                                        <h5 class="card-title">No Jobs Available</h5>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
