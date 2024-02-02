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
                    {{-- Add qualification modal --}}
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Launch demo modal
                    </button> --}}
                    {{-- Add qualification modal --}}
                    <button type="button" class="float-end btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addQualificationModal">
                        Add Qualification
                    </button>

                </div>
                <div class="card-body">

                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Qualification Name</th>
                                <th>Available Jobs</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>

    {{-- Add qualification modal --}}
    <div class="modal fade" id="addQualificationModal" tabindex="-1" aria-labelledby="addQualificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addQualificationForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQualificationModalLabel">Add Qualification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="addQualificationName">Qualification Name</label>

                            <input type="text" class="form-control" id="addQualificationName" name="addQualificationName"
                                placeholder="Enter Qualification Name">
                            <span id="addNameError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Qualification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Add qualification modal --}}

    {{-- Edit qualification modal --}}

    <div class="modal fade" id="editQualificationModal" tabindex="-1" aria-labelledby="editQualificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editQualificationForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editQualificationModalLabel">Edit Qualification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="qualificationName">Qualification Name</label>

                            <input type="text" class="form-control" id="qualificationName" name="qualificationName"
                                placeholder="Enter Qualification Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit Qualification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    {{-- Edit qualification modal --}}

    {{-- Delete qualification modal --}}


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // get all qualification
            getQualifications();
        });

        // get all qualification function
        function getQualifications() {

            $(function() {
                let table = $('.data-table').DataTable({

                    ajax: "{{ route('admin.qualification.getAll') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
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
                        },
                    ]
                });
            });


        }

        // add qualification function

        $('#addQualificationForm').submit(function(e) {
            e.preventDefault();
            var name = $('#addQualificationName').val();
            var _token = $("input[name='_token']").val();
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
                        getQualifications();
                    }
                },
                error: function(response) {
                    console.log("BackEndResponse : ", response);
                    $('#addNameError').text(response.responseJSON.errors.name);
                },
            });
        });


        // delete qualification function
        $(document).on('click', '#deleteQualification', function() {

            var qualificationId = $(this).data('id');
            var _token = $("input[name='_token']").val();
            if (confirm("Do you want to delete this qualification?")) {
                $.ajax({
                    url: "{{ route('admin.qualification.delete') }}",
                    method: "GET",
                    data: {
                        id: qualificationId,
                        _token: _token
                    },
                    success: function(response) {
                        console.log("BackEndResponse : ", response);
                        if (response) {
                            getQualifications();
                        }
                    }
                });
            }

        });

        // edit qualification function
        $(document).on('click', '#editQualification', function() {
            var qualificationId = $(this).data('id');
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('admin.qualification.edit') }}",
                method: "GET",
                data: {
                    id: qualificationId,
                    _token: _token
                },
                success: function(response) {
                    console.log("BackEndResponse : ", response);
                    $('#editQualificationModal').modal('show');
                    $('#qualificationName').val(response.name);
                    $('#editQualificationForm').submit(function(e) {
                        e.preventDefault();
                        var qualificationName = $('#qualificationName').val();
                        var _token = $("input[name='_token']").val();
                        $.ajax({
                            url: "{{ route('admin.qualification.update') }}",
                            method: "POST",
                            data: {
                                id: qualificationId,
                                name: qualificationName,
                                _token: _token
                            },
                            success: function(response) {
                                console.log("BackEndResponse : ", response);
                                if (response) {
                                    $('#editQualificationModal').modal('hide');
                                    $('#editQualificationForm')[0].reset();
                                    getQualifications();
                                }
                            }
                        });
                    });
                }
            });
        });
    </script>
@endsection
