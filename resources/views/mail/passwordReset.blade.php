{{-- @component('mail::message')
    # Hello {{ $username }},

    You are receiving this email because we received a password reset request for your account.

    @component('mail::button', ['url' => $url])
        Reset Password
    @endcomponent

    This password reset link will expire in 60 minutes.

    If you did not request a password reset, no further action is required.

    Thanks,
    {{ config('constants.APP_NAME') }}
@endcomponent --}}
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicons -->
    <link href="{{ asset('admin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <title>
        Forgot Password
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="">
    <div class=" container">
        <div class="card m-auto mt-5">
            <div class="card-header">
                <h3 class="text-center">
                    Forgot Password
                </h3>

                <p class="">
                    You are receiving this email because we received a password reset request for your account.
                </p>

                <a href="{{ $url }}" class="btn btn-sm d-block text-center btn-primary">
                    Reset Password
                </a>


                <p class="mt-3">
                    This password reset link will expire in 60 minutes.
                </p>

                <p>
                    If you did not request a password reset, no further action is required.
                </p>

                <p>Thanks,</p>

                <p>{{ config('constants.APP_NAME') }}</p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
