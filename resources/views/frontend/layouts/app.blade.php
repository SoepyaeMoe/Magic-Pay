<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    {{-- google font(opne, san) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins:ital,wght@0,100;0,200;0,300;1,200&display=swap"
        rel="stylesheet">

    {{-- box icon cdn --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>@yield('title')</title>
    @yield('extra_css')
</head>

<body>
    {{-- header menu --}}
    <div class="header_menu py-2 z-1 overflow-x-hidden mb-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-2 text-center">
                        @if (!request()->is('/'))
                            <a href="#" class="back_btn">
                                <i class='bx bx-arrow-back'></i>
                            </a>
                        @endif
                    </div>
                    <div class="col-8 text-center">
                        <h3>@yield('title')</h3>
                    </div>
                    <div class="col-2 text-center">
                        <a href="{{ route('notification') }}">
                            <i class='bx bxs-bell position-relative'>
                                @if ($unread_noti_count > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-1 pt-0">
                                        <small>{{ $unread_noti_count }}</small>
                                    </span>
                                @endif
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content overflow-x-hidden" style="width: 100%; padding: 10px;">
        <div class="d-flex justify-content-center">
            <div class="col-md-8 col-12">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- bottom menu --}}
    <div class="bottom_menu py-1 overflow-x-hidden">
        <a href="{{ url('scan-to-pay') }}" class="scan_tab">
            <div class="inside">
                <i class='bx bx-scan'></i>
            </div>
        </a>
        <div class="d-flex justify-content-center">
            <div class="col-md-8 col-12">
                <div class="row">
                    <div class="col text-center">
                        <a href="{{ route('home') }}" class="@yield('home_active')">
                            <i class='bx bxs-home'></i>
                            <p class="mb-0">Home</p>
                        </a>
                    </div>
                    <div class="col text-center">
                        <a href="{{ route('wallet') }}" class="@yield('wallet_active')">
                            <i class='bx bxs-wallet'></i>
                            <p class="mb-0">Wallet</p>
                        </a>
                    </div>
                    <div class="col text-center">
                        <a href="{{ route('transaction') }}" class="@yield('history_active')">
                            <i class='bx bxs-report'></i>
                            <p class="mb-0">History</p>
                        </a>
                    </div>
                    <div class="col text-center">
                        <a href="{{ route('profile') }}" class="@yield('profile_active')">
                            <i class='bx bxs-user'></i>
                            <p class="mb-0">Account</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    {{-- jquery cdn --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- jscroll --}}
    <script src="{{ asset('frontend/js/jscroll.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        });

        // sweet session alert
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
        @if (session('update'))
            Toast.fire({
                icon: "success",
                title: "{{ session('update') }}"
            });
        @endif

        $('.back_btn').on('click', function(e) {
            e.preventDefault;
            window.history.back();
        })
    </script>
    @yield('scripts')

</body>

</html>
