<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') {{ config('app.name') }} </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <!-- Datatable -->
    <link href="{{ asset('assets/admin-ui/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('assets/admin-ui/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin-ui/css/dev.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
    @include('partials.adminui.footer')
    <!-- Required vendors -->
    <script src="{{ asset('assets/admin-ui/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/admin-ui/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('assets/admin-ui/js/custom.min.js') }}"></script>

    <script src="{{ asset('assets/js/notify.min.js') }}"></script>



    <!-- Datatable -->
    <script src="{{ asset('assets/admin-ui/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin-ui/js/plugins-init/datatables.init.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @yield('scripts')
</body>

</html>
