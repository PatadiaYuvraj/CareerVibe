@extends('user.profile.layout.app')
@section('title', 'Your Followers')
@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="job-items mb-3">
            @forelse ($users as $key =>$user)
                <div class="manage-content mb-2 card py-2 px-4">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-3 col-md-3 col-12">
                            <h6>
                                {{ $user->name }}
                            </h6>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <p>
                                <span class="time">
                                    {{ $user->email }}
                                </span>
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            {{--  --}}
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="button">
                                <a href="{{ route('user.removeFollower', $user['id']) }}" class="btn px-3 py-2">Remove
                                    Follower</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="manage-content mb-4 card py-4 px-4">
                    <div class="row text-center">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h6>
                                No followers found.
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
