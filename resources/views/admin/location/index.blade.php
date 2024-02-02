@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Locations</span>
                    <button type="button" class="float-end btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addLocationModal">
                        <i class="bi bi-plus-square">&nbsp;Add Location</i>
                    </button>
                </div>
                <div class="card-body">
                    @include('admin.location.modals._table')
                </div>
            </div>
        </section>
    </main>
@endsection

@include('admin.location.modals._add')

@include('admin.location.modals._edit')

@include('admin.location.modals._show')

@section('scripts')
    <script>
        $(document).ready(function() {

            let table = $('#data-table').DataTable({

                // ajax: function(data, callback, settings) {
                //     $.ajax({
                //         url: "{{ route('admin.location.getAll') }}",
                //         method: "GET",
                //         data: data,
                //         success: function(response) {
                //             console.log({
                //                 data
                //             })
                //             console.log("BackEndResponse : ", response);
                //             callback(response);
                //         },
                //         error: function(response) {
                //             console.log("BackEndResponse : ", response);
                //         },
                //     });
                // },
                ajax: "{{ route('admin.location.getAll') }}",
                processing: true,
                serverSide: true,
                columns: [{
                        // loop iteration
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: function(data) {
                            return data.state ? data.state : 'N/A';
                        },
                        name: 'state'
                    },
                    {
                        data: function(data) {
                            return data.country ? data.country : 'N/A';
                        },
                        name: 'country'
                    },
                    {
                        data: function(data) {
                            return data.pincode ? data.pincode : 'N/A';
                        },
                        name: 'pincode'
                    },
                    {
                        data: 'jobs_count',
                        name: 'jobs_count'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#addLocationForm').submit(function(e) {
                e.preventDefault();
                $('#addNameError').text('');
                var city = $('#addLocationCity').val();
                var state = $('#addLocationState').val();
                var country = $('#addLocationCountry').val();
                var pincode = $('#addLocationPincode').val();
                var _token = $("input[name='_token']").val();
                addData(
                    city, state, country, pincode, _token);
            });

            $(document).on('click', '.showLocation', function() {
                console.log($(this).data('id'))
                var locationId = $(this).data('id');
                var _token = $("input[name='_token']").val();
                console.log(locationId);
                showData(locationId, _token);
            });

            $(document).on('click', '#refreshTable', function() {
                table.ajax.reload();
            });

            $(document).on('click', '.deleteLocation', function() {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this location!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var locationId = $(this).data('id');
                        var _token = $("input[name='_token']").val();

                        deleteData(locationId, _token);
                    }
                })

            });

            $(document).on('click', '.editLocation', function() {
                var locationId = $(this).data('id');
                var _token = $("input[name='_token']").val();

                editData(locationId, _token);
            });

            const addData = (
                city, state, country, pincode, _token) => {
                $.ajax({
                    url: "{{ route('admin.location.store') }}",
                    method: "POST",
                    data: {
                        city,
                        state,
                        country,
                        pincode,
                        _token,
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ", response);
                        if (response) {
                            $('#addLocationModal').modal('hide');
                            $('#addLocationForm')[0].reset();
                            table.ajax.reload();
                            toastr.success(response.success);
                        }
                    },
                    error: function(response) {
                        console.log("BackEndResponse : ", response);
                        $('#addCityError').text(response.responseJSON.errors.city);
                        $('#addStateError').text(response.responseJSON.errors.state);
                        $('#addCountryError').text(response.responseJSON.errors.country);
                        $('#addPincodeError').text(response.responseJSON.errors.pincode);
                    },
                });
            }

            const showData = (locationId, _token) => {
                $.ajax({
                    url: "{{ route('admin.location.show') }}",
                    method: "GET",
                    data: {
                        id: locationId,
                        _token: _token
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ", response);
                        $('#showLocationModal').modal('show');
                        $('#showLocationCity').text(response.city);
                        $('#showLocationState').text(response.state ? response.state : 'N/A');
                        $('#showLocationCountry').text(response.country ? response.country : 'N/A');
                        $('#showLocationPincode').text(response.pincode ? response.pincode : 'N/A');
                        $('#showLocationJobs').text(response.jobs.length);
                        var jobs = response.jobs;
                        var html = '<ul class="card-link">';
                        for (let i = 0; i < jobs.length; i++) {
                            html += '<li class="text-decoration-none">' + jobs[i].sub_profile.name +
                                ' by ' + jobs[i].company.name + ' </li>';
                        }
                        html += '</ul>';
                        $('#showJobs').html(html);

                    },
                    error: function(response) {
                        console.log("BackEndResponse : ", response);
                        toastr.warning(response.responseJSON.warning);
                    },
                });
            }

            const editData = (locationId, _token) => {
                $.ajax({
                    url: "{{ route('admin.location.edit') }}",
                    method: "GET",
                    data: {
                        id: locationId,
                        _token: _token
                    },
                    success: function(response) {
                        console.log("BackEndResponseSuccess : ", response);
                        $('#editLocationModal').modal('show');
                        $('#editLocationCity').val(response.city);
                        $('#editLocationState').val(response.state);
                        $('#editLocationCountry').val(response.country);
                        $('#editLocationPincode').val(response.pincode);
                        $('#editLocationForm').submit(function(e) {
                            e.preventDefault();
                            var city = $('#editLocationCity').val();
                            var state = $('#editLocationState').val();
                            var country = $('#editLocationCountry').val();
                            var pincode = $('#editLocationPincode').val();
                            var _token = $("input[name='_token']").val();
                            updateData(locationId, city, state, country, pincode, _token);
                        });
                    },
                    error: function(response) {
                        console.log("BackEndResponse : ", response);
                        toastr.warning(response.responseJSON.warning);
                    },
                });
            };

            const deleteData = (locationId, _token) => {
                $.ajax({
                    url: "{{ route('admin.location.delete') }}",
                    method: "GET",
                    data: {
                        id: locationId,
                        _token: _token
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ", response);
                        toastr.success(response.success);
                        table.ajax.reload();
                    },
                    error: function(response) {
                        console.log("BackEndResponse : ", response);
                        toastr.warning(response.responseJSON.warning);
                    },
                });
            }

            const updateData = (locationId, city, state, country, pincode, _token) => {
                $.ajax({
                    url: "{{ route('admin.location.update') }}",
                    method: "POST",
                    data: {
                        id: locationId,
                        city,
                        state,
                        country,
                        pincode,
                        _token
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ",
                            response);
                        if (response) {
                            $('#editLocationModal').modal(
                                'hide');
                            $('#editLocationForm')[0]
                                .reset();
                            toastr.success(response.success);
                            table.ajax.reload();
                        }
                    },
                    error: function(response) {
                        console.log("BackEndResponse : ",
                            response);
                        $('#editCityError').text(response.responseJSON.errors.city);
                        $('#editStateError').text(response.responseJSON.errors.state);
                        $('#editCountryError').text(response.responseJSON.errors.country);
                        $('#editPincodeError').text(response.responseJSON.errors.pincode);
                    },
                });
            }
        });
    </script>
@endsection
