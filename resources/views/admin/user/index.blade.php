@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Users</span>
                    {{-- <span><button class="float-end btn btn-sm btn-primary">Add User</button></span> --}}

                    <a href="{{ route('admin.user.create') }}" class="float-end btn btn-sm btn-primary">Add User</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $user['name'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>{{ date('d-m-Y', strtotime($user['created_at'])) }}</td>
                                            <td>
                                                <a href="{{ route('admin.user.edit', $user['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.user.delete', $user['id']) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No Data Found</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
