@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Company</span>
                    <a href="{{ route('admin.company.create') }}" class="float-end btn btn-sm btn-primary">Add Company</a>
                </div>
                <div class="card-body">
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th class="col-2">Name</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $d)
                                <tr>
                                    <td>{{ $d['name'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100" class="text-center">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </section>

    </main>
@endsection
