@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    {{-- Company --}}
                    <span class="h3 text-black">Company</span>
                    <a href="{{ route('admin.company.create') }}" class="float-end btn btn-sm btn-primary">Add Company</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">

                            <!-- Table with stripped rows -->
                            <table class="table table-striped">
                                {{-- populate data of company in table --}}
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th>Company Email</th>
                                        <th>Company Website</th>
                                        <th>Verified</th>
                                        {{-- <th>Created At</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('admin.company.show', $company['id']) }}">
                                                    {{ $company['name'] }}
                                                </a>
                                            </td>
                                            <td>{{ $company['email'] }}</td>
                                            <td>{{ $company['website'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.company.toggleVerified', [$company['id'], $company['is_verified']]) }}"
                                                    class=" badge bg-{{ $company['is_verified'] ? 'success' : 'danger' }}">
                                                    {{ $company['is_verified'] ? 'Verified' : 'Not Verified' }}
                                                </a>
                                            </td>
                                            {{-- <td>{{ date('d-m-Y', strtotime($company['created_at'])) }}</td> --}}
                                            <td class="col-2">
                                                <div class="btn-group btn-group-sm d-flex">
                                                    @if ($company['is_verified'])
                                                        <a href="{{ route('admin.job.create', $company['id']) }}"
                                                            class="btn btn-sm btn-primary">Add Job</a>
                                                    @endif
                                                    <a href="{{ route('admin.company.edit', $company['id']) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('admin.company.delete', $company['id']) }}"
                                                        class="btn btn-sm btn-primary">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
