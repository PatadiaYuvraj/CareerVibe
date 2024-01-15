@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Locations
                    </span>
                    <a href="{{ route('admin.location.create') }}" class="float-end btn btn-sm btn-primary">Add
                        Location</a>
                </div>
                <div class="card-body">
                    <table class="table  table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Pin Code</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locations as $location)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin.location.show', $location['id']) }}">{{ $location['city'] }}
                                        </a>
                                    </td>
                                    <td>{{ $location['state'] }}</td>
                                    <td>{{ $location['country'] }}</td>
                                    <td>{{ $location['pincode'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($location['created_at'])) }}</td>
                                    <td>
                                        <a href="{{ route('admin.location.edit', $location['id']) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a href="{{ route('admin.location.delete', $location['id']) }}"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Location Found</td>
                                </tr>
                            @endforelse
                    </table>
                    <div class="justify-content-center">
                        {{ $locations->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
