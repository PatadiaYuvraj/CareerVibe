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
                            <table class="table datatable">
                                {{-- populate data of location in table --}}
                                <thead>
                                    <tr>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Pin Code</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($locations as $location)
                                        <tr>
                                            <td>{{ $location['city'] }}</td>
                                            <td>{{ $location['state'] }}</td>
                                            <td>{{ $location['country'] }}</td>
                                            <td>{{ $location['pincode'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.location.edit', $location['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.location.delete', $location['id']) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No Data Found</td>
                                        </tr>
                                    @endforelse
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
