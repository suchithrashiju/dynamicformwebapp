<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') {{ config('app.name') }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/admin-ui/images/favicon.png') }}">
    <link href="{{ asset('assets/admin-ui/css/style.css') }}" rel="stylesheet">

</head>

<body class="h-100">
    @yield('content')


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/admin-ui/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/admin-ui/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('assets/admin-ui/js/custom.min.js') }}"></script>

</body>

</html>
