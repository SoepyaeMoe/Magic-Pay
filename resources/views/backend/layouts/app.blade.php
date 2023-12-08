<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font: Source Sans Pro -->
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">

    <link rel="stylesheet" href="{{ asset(url('backend/plugins/fontawesome-free/css/all.min.css')) }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset(url('backend/dist/css/adminlte.min.css')) }}">

    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset(url('backend/dist/css/style.css')) }}">
    @yield('extra_css')
    <title>@yield('title')</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('backend.layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('backend.layouts.side')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper px-3">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            @yield('content')

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer bg-light">
            <strong>Copyright &copy; {{ now()->format('Y') }} <a href="https://adminlte.io">MagicPay</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                Develop by <b>Soe Pyae Moe</b>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset(url('backend/plugins/jquery/jquery.min.js')) }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset(url('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')) }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset(url('backend/dist/js/adminlte.js')) }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset(url('backend/plugins/chart.js/Chart.min.js')) }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset(url('backend/dist/js/demo.js')) }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset(url('backend/dist/js/pages/dashboard3.js')) }}"></script>

    {{-- Data Table  --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')
    <script>
        // ajax csrf token setup
        let token = document.head.querySelector('meta[name="csrf_token"]');
        if (token) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF_TOKEN': token.content
                }
            })
        }

        //back button
        $(document).ready(function() {
            $('.back_btn').click(function() {
                window.history.back();
            })
        });

        // success alert
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        @if (session('create'))
            Toast.fire({
                icon: "success",
                title: "{{ session('create') }}"
            });
        @endif
    </script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
</body>

</html>
