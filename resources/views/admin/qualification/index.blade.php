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
                    <table class="table  table-striped">
                        <thead>
                            <tr>
                                <th class="col-2">#</th>
                                <th class="col-7">Name</th>
                                <th class="col-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($qualifications as $qualification)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin.qualification.show', $qualification['id']) }}">{{ $qualification['qualification'] }}
                                        </a>
                                    </td>
                                    <td class="">
                                        <a href="{{ route('admin.qualification.edit', $qualification['id']) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a href="{{ route('admin.qualification.delete', $qualification['id']) }}"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Qualification Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {{ $qualifications->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            </div>
            </div>
        </section>

    </main>
@endsection
