<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicons -->
    <link href="{{ asset('admin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <title>
        Email Verification
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="">
    <div class=" container">
        <div class="card m-auto mt-5">
            <div class="card-header">
                <h3 class="text-center">Email Verification</h3>

                <p class="">Thank you for creating an account with us. Please verify your email address
                    using the link below:</p>

                <a href="{{ $url }}" class="btn btn-sm d-block text-center btn-primary">Verify Email
                    Address</a>


                <p class="mt-3">If you did not create an account, no further action is required.</p>

                <p>Thanks,</p>

                <p>{{ config('constants.APP_NAME') }}</p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
