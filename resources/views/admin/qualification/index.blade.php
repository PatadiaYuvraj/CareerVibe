@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Qualifications </span>
                    <button type="button" class="float-end btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addQualificationModal">
                        <i class="bi bi-plus-square"> Add Qualification</i>
                    </button>
                </div>
                <div class="card-body">
                    @include('admin.qualification.modals._table') {{-- qualifications table --}}
                </div>
            </div>
        </section>
    </main>
@endsection

@include('admin.qualification.modals._add') {{-- add qualification modal --}}

@include('admin.qualification.modals._edit') {{-- edit qualification modal --}}

@include('admin.qualification.modals._show') {{-- show qualification modal --}}


@section('scripts')
    <script>
        $(document).ready(function() {

            let table = $('#data-table').DataTable({

                ajax: "{{ route('admin.qualification.getAll') }}",
                columns: [{
                        // loop iteration
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name'
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

            $('#addQualificationForm').submit(function(e) {
                e.preventDefault();
                $('#addNameError').text('');
                var name = $('#addQualificationName').val();
                var _token = $("input[name='_token']").val();
                addData(name, _token);
            });

            $(document).on('click', '.showQualification', function() {
                console.log($(this).data('id'))
                var qualificationId = $(this).data('id');
                var _token = $("input[name='_token']").val();
                showData(qualificationId, _token);
            });

            $(document).on('click', '#refreshTable', function() {
                table.ajax.reload();
            });

            $(document).on('click', '.deleteQualification', function() {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this qualification!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var qualificationId = $(this).data('id');
                        var _token = $("input[name='_token']").val();

                        deleteData(qualificationId, _token);
                    }
                })

            });

            $(document).on('click', '.editQualification', function() {
                var qualificationId = $(this).data('id');
                var _token = $("input[name='_token']").val();

                editData(qualificationId, _token);
            });

            const addData = (name, _token) => {
                $.ajax({
                    url: "{{ route('admin.qualification.store') }}",
                    method: "POST",
                    data: {
                        name,
                        _token,
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ", response);
                        if (response) {
                            $('#addQualificationModal').modal('hide');
                            $('#addQualificationForm')[0].reset();
                            table.ajax.reload();
                            toastr.success(response.success);
                        }
                    },
                    error: function(response) {
                        console.log("BackEndResponse : ", response);
                        $('#addNameError').text(response.responseJSON.errors.name);
                    },
                });
            }

            const showData = (qualificationId, _token) => {
                $.ajax({
                    url: "{{ route('admin.qualification.show') }}",
                    method: "GET",
                    data: {
                        id: qualificationId,
                        _token: _token
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ", response);
                        $('#showQualificationModal').modal('show');
                        $('#showQualificationName').text(response.name);
                        $('#showQualificationJobs').text(response.jobs.length);
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

            const editData = (qualificationId, _token) => {
                $.ajax({
                    url: "{{ route('admin.qualification.edit') }}",
                    method: "GET",
                    data: {
                        id: qualificationId,
                        _token: _token
                    },
                    success: function(response) {
                        console.log("BackEndResponseSuccess : ", response);
                        $('#editQualificationModal').modal('show');
                        $('#editQualificationName').val(response.name);
                        $('#editQualificationForm').submit(function(e) {
                            e.preventDefault();
                            var name = $('#editQualificationName')
                                .val();
                            var _token = $("input[name='_token']").val();
                            updateData(qualificationId, name, _token);
                        });
                    },
                    error: function(response) {
                        console.log("BackEndResponse : ", response);
                        toastr.warning(response.responseJSON.warning);
                    },
                });
            };

            const deleteData = (qualificationId, _token) => {
                $.ajax({
                    url: "{{ route('admin.qualification.delete') }}",
                    method: "GET",
                    data: {
                        id: qualificationId,
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

            const updateData = (qualificationId, name, _token) => {
                $.ajax({
                    url: "{{ route('admin.qualification.update') }}",
                    method: "POST",
                    data: {
                        id: qualificationId,
                        name,
                        _token
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ",
                            response);
                        if (response) {
                            $('#editQualificationModal').modal(
                                'hide');
                            $('#editQualificationForm')[0]
                                .reset();
                            toastr.success(response.success);
                            table.ajax.reload();
                        }
                    },
                    error: function(response) {
                        console.log("BackEndResponse : ",
                            response);
                        $('#editNameError').text(response
                            .responseJSON.errors.name);
                    },
                });
            }
        });
    </script>
@endsection
