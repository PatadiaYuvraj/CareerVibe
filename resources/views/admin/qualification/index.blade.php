@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Qualifications
                    </span>
                    <a href="{{ route('admin.qualification.create') }}" class="float-end btn btn-sm btn-primary">Add
                        Qualification</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                {{-- populate data of qualification in table --}}
                                <thead>
                                    <tr>
                                        <th>name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($qualifications as $qualification)
                                        <tr>
                                            <td>{{ $qualification['qualification'] }}</td>
                                            <td>{{ $qualification['created_at'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.qualification.edit', $qualification['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.qualification.delete', $qualification['id']) }}"
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
