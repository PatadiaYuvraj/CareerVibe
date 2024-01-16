<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="{{ asset('admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
    <form action="{{ route('testing') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- <div class="card">
            <div class="card-body">

                <textarea class="tinymce-editor" name="name"></textarea>
            </div>
        </div> --}}
        <input type="file" name="file" id="file">
        <br>
        <button class="btn btn-primary" type="submit">Send</button>
    </form>
</body>
<script src="{{ asset('admin/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('admin/vendor/tinymce/tinymce.min.js') }}"></script>


<!-- Template Main JS File -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/main.js') }}"></script>

</html>
