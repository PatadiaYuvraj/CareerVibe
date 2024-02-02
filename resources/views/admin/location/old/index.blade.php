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
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th class="col-1">#</th>
                                <th class="col-2">City</th>
                                <th class="col-1">State</th>
                                <th class="col-1">Country</th>
                                <th class="col-2">Pin Code</th>
                                <th class="col-2">Available Jobs</th>
                                <th class="col-2">Created At</th>
                                <th class="col-1">Action</th>
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
                                    <td>
                                        @if ($location['state'] != null)
                                            {{ $location['state'] }}
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($location['country'] != null)
                                            {{ $location['country'] }}
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($location['pincode'] != null)
                                            {{ $location['pincode'] }}
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ $location['jobs_count'] }}</td>

                                    @if ($location['created_at'] != null)
                                        <td>{{ $location['created_at']->format('d-m-Y') }}</td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                    <td class="btn-group">
                                        <a href="{{ route('admin.location.edit', $location['id']) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a href="{{ route('admin.location.delete', $location['id']) }}"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Location Found</td>
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
