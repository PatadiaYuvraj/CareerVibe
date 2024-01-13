@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Job Profile
                    </span>
                    <a href="{{ route('admin.job-profile.create') }}" class="float-end btn btn-sm btn-primary">Add
                        profile</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-striped">
                                {{-- populate data of qualification in table --}}
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($profiles as $profile)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $profile['profile'] }}</td>
                                            <td>{{ date('d-m-Y', strtotime($profile['created_at'])) }}</td>
                                            <td>
                                                <a href="{{ route('admin.job-profile.edit', $profile['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.job-profile.delete', $profile['id']) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- paginate    --}}
                            <div class="justify-content-center">
                                {{ $profiles->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
