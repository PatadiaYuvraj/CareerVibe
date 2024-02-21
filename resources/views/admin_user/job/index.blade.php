@extends('admin_user.layout.app')
@section('pageTitle', 'Available Jobs | ' . env('APP_NAME'))
@section('content')

    @php
        $work_types = Config::get('constants.job.work_type');
    @endphp

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle"><span class="h3 text-black">Job </span>


                    {{-- <div class="float-end d-flex btn-group row "> --}}
                    <div class="dropdown float-end">
                        <button class="btn btn-info btn-sm dropdown-toggle filter-btn" type="button" id="filterDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        </button>
                        <ul class="dropdown-menu overflow-y-auto" style="height: 250px" aria-labelledby="filterDropdown">
                            <li>
                                <a class="dropdown-item filter-all" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'all')">All</a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-saved" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'saved')">Saved</a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-applied" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'applied')">Applied</a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item filter-active" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'active')">Active</a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-featured" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'featured')">Featured</a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-verified" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'verified')">Verified</a>
                            </li> --}}
                            <li>
                                <a class="dropdown-item filter-newest" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'newest')">Newest</a>
                            </li>
                            <li>
                                <a class="dropdown-item  filter-oldest" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'oldest')">Oldest</a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-highest" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'salary_high')">
                                    Highest Salary
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-lowest" href="#"
                                    onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', 'salary_low')">
                                    Lowest Salary
                                </a>
                            </li>
                            {{-- work_types --}}
                            @foreach ($work_types as $value)
                                <li>
                                    <a class="dropdown-item filter-work-type-{{ Str::lower($value) }}" href="#"
                                        onclick="fetchJobs('{{ route('admin_user.job.getAllJobs') }}', '{{ Str::lower($value) }}')">
                                        {{ $value }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    {{-- </div> --}}



                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Job Profile</th>
                                <th class="col-1">Vacancy</th>
                                <th>Salary</th>
                                <th class="col-1">Type</th>
                                <th class="col-1">Verified</th>
                                <th class="col-1">Featured</th>
                                <th class="col-1">Active</th>
                                <th class="col-1">Applied</th>
                                <th class="col-1">Saved</th>
                            </tr>
                        </thead>
                        <tbody id="jobs"></tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div id="pagination" class="d-flex justify-content-center gap-2" aria-label="Page navigation example">
                    </div>
                </div>
            </div>
        </section>
    </main>@endsection @section('scripts')
    <script>
        const fetchJobs = (
            url = "{{ route('admin_user.job.getAllJobs') . '?page=1' }}",
            filter = 'all',
        ) => {

            console.log({
                url,
                filter,
            });
            // sort-btn


            $(
                    '.filter-all, .filter-saved, .filter-applied, .filter-active, .filter-featured, .filter-verified, .filter-newest, .filter-oldest, .filter-highest, .filter-lowest, .filter-work-type-remote, .filter-work-type-onsite, .filter-work-type-hybrid'
                )
                .removeClass('active');

            if (filter == 'all') {
                $('.filter-btn').text('All');
                $('.filter-all').addClass('active');
            } else if (filter == 'saved') {
                $('.filter-btn').text('Saved');
                $('.filter-saved').addClass('active');
            } else if (filter == 'applied') {
                $('.filter-btn').text('Applied');
                $('.filter-applied').addClass('active');
            } else if (filter == 'active') {
                $('.filter-btn').text('Active');
                $('.filter-active').addClass('active');
            } else if (filter == 'featured') {
                $('.filter-btn').text('Featured');
                $('.filter-featured').addClass('active');
            } else if (filter == 'verified') {
                $('.filter-btn').text('Verified');
                $('.filter-verified').addClass('active');
            } else if (filter == 'newest') {
                $('.filter-btn').text('Newest');
                $('.filter-newest').addClass('active');
            } else if (filter == 'oldest') {
                $('.filter-btn').text('Oldest');
                $('.filter-oldest').addClass('active');
            } else if (filter == 'salary_high') {
                $('.filter-btn').text('Highest Salary');
                $('.filter-highest').addClass('active');
            } else if (filter == 'salary_low') {
                $('.filter-btn').text('Lowest Salary');
                $('.filter-lowest').addClass('active');
            } else if (filter == 'remote') {
                $('.filter-btn').text('Remote');
                $('.filter-work-type-remote').addClass('active');
            } else if (filter == 'onsite') {
                $('.filter-btn').text('Onsite');
                $('.filter-work-type-onsite').addClass('active');
            } else if (filter == 'hybrid') {
                $('.filter-btn').text('Hybrid');
                $('.filter-work-type-hybrid').addClass('active');
            }

            $.ajax({
                url,
                type: "GET",
                data: {
                    filter,
                },
                success: function(response) {
                    $('#jobs').html('');


                    if (response.data.length > 0) {
                        response.data.map(function(job) {
                            $('#jobs').append(`
                                <tr>
                                    <td>
                                        ${job.sub_profile.name}
                                    </td>
                                    <td>${job.vacancy}</td>
                                    <td>
                                        ${job.min_salary >= 1000 ? job.min_salary / 1000 + 'k - ' + job.max_salary / 1000 + 'k' : job.min_salary + ' - ' + job.max_salary}
                                    </td>
                                    <td>${job.work_type}</td>
                                    <td>
                                        <a class="badge bg-${job.is_verified ? 'success' : 'danger'}">
                                            ${job.is_verified ? 'Verified' : 'Not Verified'}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="badge bg-${job.is_featured ? 'success' : 'danger'}">
                                            ${job.is_featured ? 'Featured' : 'Not Featured'}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="badge bg-${job.is_active ? 'success' : 'danger'}">
                                            ${job.is_active ? 'Active' : 'Not Active'}
                                        </a>
                                    </td>
                                    <td>
                                        ${job.is_applied ? '<a href="' + "{{ route('admin_user.job.unapply', '') }}/" + job.id + '" class="badge bg-success">Applied</a>' : '<a href="' + "{{ route('admin_user.job.apply', '') }}/" + job.id + '" class="badge bg-info">Apply Now</a>'}
                                    </td>
                                    <td>
                                        ${job.is_saved ? '<a href="' + "{{ route('admin_user.job.unsaveJob', '') }}/" + job.id + '" class="badge bg-success">Saved</a>' : '<a href="' + "{{ route('admin_user.job.saveJob', '') }}/" + job.id + '" class="badge bg-info">Save Now</a>'}
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#jobs').append(`
                            <tr>
                                <td colspan="20" class="text-center">No Job Found</td>
                            </tr>
                        `);
                    }



                    // Pagination
                    $('#pagination').html('');
                    response.links.map(function(link) {

                        $('#pagination').append(`
                            <ul class="pagination pagination-sm">
                                <li class="page-item ${link.active ? 'active' : ''} ${link.url == null ? 'disabled' : ''}">
                                    <a class="page-link" onclick="fetchJobs('${link.url}',
                                        '${filter}'
                                    )" href="#">${link.label}</a>
                                </li>
                            </ul>
                        `);

                    });
                }
            });
        }
        $(document).ready(function() {
            fetchJobs();
        });
    </script>
@endsection
