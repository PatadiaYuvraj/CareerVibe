<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Send Mail</title>
</head>

<body>
    <x-mail::message>
        # {{ $title }}

        {{ $body }}

        # Thanks,
        {{ config('constants.APP_NAME') }}
    </x-mail::message>
</body>

</html>
