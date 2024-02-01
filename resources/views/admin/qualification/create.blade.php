@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Qualification</span>
                    <a href="{{ route('admin.qualification.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form {{-- action="{{ route('admin.qualification.store') }}"  --}} method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Qualification
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name') }}">
                            <span class="text-danger" id="nameError"></span>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.qualification.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#submit').click(function() {
                $(this).attr('disabled', true);
                $(this).parents('form').submit();

                createQualification();

            });
        });

        // create qualification function
        function createQualification() {
            // clear error msg
            $('#nameError').text('');
            // ajax request
            $.ajax({
                url: "{{ route('admin.qualification.storeAjax') }}",
                method: "POST",
                data: {
                    name: $('#name').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        $('#submit').attr('disabled', false);
                        $('#name').val('');
                        // redirect to index page
                        window.location.href = "{{ route('admin.qualification.index') }}";
                        toastr.success(response.message);
                    } else {
                        $('#submit').attr('disabled', false);
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    console.log(error.responseJSON.errors);
                    // show error msg in span 
                    $('#nameError').text(error.responseJSON.errors.name);
                    $('#submit').attr('disabled',
                        false);
                }
            });
        }
    </script>
@endsection
