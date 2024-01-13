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
                    <div class="card">
                        <div class="card-body">

                            <!-- Table with stripped rows -->
                            <table class="table  table-striped">
                                {{-- populate data of location in table --}}
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

                                    @foreach ($locations as $location)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $location['city'] }}</td>
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
                                    @endforeach

                            </table>
                            <div class="justify-content-center">
                                {{ $locations->links('pagination::bootstrap-5') }}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
