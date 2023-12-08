@extends('frontend.layouts.app')
@section('title', 'Magic Pay')
@section('home_active', 'active')

@section('content')
    <div class="home">
        <div class="row">
            <div class="col-12">
                <div class="profile_img mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random" alt="">
                    <h6 class="text-center mt-2">{{ $user->name }}</h6>
                    <p class="text-muted text-center">{{ $user->wallet ? number_format($user->wallet->amount, 2) : '0.00' }}
                        MMK
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="{{ url('/scan-to-pay') }}">
                    <div class="card shortcut_box mb-3">
                        <div class="card-body p-2 p-sm-3">
                            <i class='bx bx-scan'></i>
                            <span class="ms-sm-5 ms-3">Scan to Pay</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ url('my-qr') }}">
                    <div class="card shortcut_box mb-3">
                        <div class="card-body p-2 p-sm-3">
                            <i class='bx bx-qr-scan'></i>
                            <span class="ms-sm-5 ms-3">My QR</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body function_box">
                        <a href="{{ route('transfer') }}" class="d-flex justify-content-between logout">
                            <span><img src="{{ asset('img/transfer-money.png') }}" alt=""> Transfer</span>
                            <span class="me-3"><i class="bx bxs-right-arrow-alt"></i></span>
                        </a>
                        <hr>
                        <a href="{{ route('wallet') }}" class="d-flex justify-content-between logout">
                            <span><img src="{{ asset('img/wallet-filled-money-tool.png') }}" alt="">Wallet</span>
                            <span class="me-3"><i class="bx bxs-right-arrow-alt"></i></span>
                        </a>
                        <hr>
                        <a href="{{ route('transaction') }}" class="d-flex justify-content-between logout">
                            <span><img src="{{ asset('img/transaction.png') }}" alt="">Transation</span>
                            <span class="me-3"><i class="bx bxs-right-arrow-alt"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
