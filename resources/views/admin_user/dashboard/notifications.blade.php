@extends('admin_user.layout.app')
@section('pageTitle', 'Notifications | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Notifications
                    </span>
                    <div class="float-end">
                        @if (count($notifications) > 0)
                            <a href="{{ route('admin_user.notification.readAll') }}" class="btn btn-sm btn-primary">Mark All
                                As
                                Read</a>
                            <a href="{{ route('admin_user.notification.deleteAll') }}" class="btn btn-sm btn-danger">Delete
                                All</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Notification</th>
                                <th>Days Ago</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notifications as $notification)
                                <tr>
                                    <td class="@if ($notification['read_at'] != null) text-muted @endif">
                                        {{ $loop->iteration }}</td>
                                    <td class="@if ($notification['read_at'] != null) text-muted @endif">
                                        {{ $notification['data'] }}</td>
                                    <td class="@if ($notification['read_at'] != null) text-muted @endif">
                                        {{ $notification['created_at']->diffForHumans() }}
                                    </td>
                                    <td class="@if ($notification['read_at'] != null) text-muted @endif">
                                        @if ($notification['read_at'] == null)
                                            <a href="{{ route('admin_user.notification.read', $notification['id']) }}"
                                                class="badge bg-primary">Mark as Read</a>
                                        @else
                                            <a href="{{ route('admin_user.notification.unread', $notification['id']) }}"
                                                class="badge bg-success">Mark as Unread</a>
                                        @endif

                                        <a href="{{ route('admin_user.notification.delete', $notification['id']) }}"
                                            class="badge bg-danger">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- <div class="justify-content-center">
                        {{ $notifications->links('pagination::bootstrap-5') }}
                    </div> --}}
                </div>
            </div>
        </section>

    </main>
@endsection
