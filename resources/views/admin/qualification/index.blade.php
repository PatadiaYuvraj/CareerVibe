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
                            <table class="table datatable table-striped">
                                {{-- populate data of qualification in table --}}
                                <thead>
                                    <tr>
                                        {{-- # --}}
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($qualifications as $qualification)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $qualification['qualification'] }}</td>
                                            {{--   print date and time of created_at --}}
                                            <td>{{ date('d-m-Y', strtotime($qualification['created_at'])) }}</td>
                                            <td>
                                                <a href="{{ route('admin.qualification.edit', $qualification['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.qualification.delete', $qualification['id']) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
