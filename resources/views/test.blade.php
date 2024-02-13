<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> </title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>

    <form action="{{ route('testing') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" />
        @error('file')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit">Upload</button>
    </form>
</body>

</html>
