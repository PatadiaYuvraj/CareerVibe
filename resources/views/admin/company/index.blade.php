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
                            <table class="table datatable">
                                {{-- populate data of company in table --}}
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Company Email</th>
                                        <th>Company Website</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{ $company['name'] }}</td>
                                            <td>{{ $company['email'] }}</td>
                                            <td>{{ $company['website'] }}</td>
                                            <td>{{ $company['created_at'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.company.edit', $company['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.company.delete', $company['id']) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
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
