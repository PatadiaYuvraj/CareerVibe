@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Profile Categories
                    </span>
                    <a href="{{ route('admin.profile-category.create') }}" class="float-end btn btn-sm btn-primary">
                        Add Profile Category
                    </a>
                </div>
                <div class="card-body">
                    <table class="table text-center table-striped">
                        <thead>
                            <tr>
                                <th class="col-2">Profile Category</th>
                                <th class="col-2">Sub Profiles</th>
                                <th class="col-2">Jobs</th>
                                <th class="col-2">Created At</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($profileCategories as $profileCategory)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.profile-category.show', $profileCategory['id']) }}">{{ $profileCategory['name'] }}
                                        </a>
                                    </td>
                                    <td>{{ $profileCategory['sub_profiles_count'] }}</td>
                                    <td>{{ $profileCategory['jobs_count'] }}</td>
                                    <td>
                                        @if ($profileCategory['created_at'])
                                            {{ date('d-m-Y', strtotime($profileCategory['created_at'])) }}
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.profile-category.edit', $profileCategory['id']) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <a href="{{ route('admin.profile-category.delete', $profileCategory['id']) }}"
                                                class="btn btn-sm btn-danger">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Job Profile Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {{ $profileCategories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
