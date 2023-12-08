@extends('frontend.layouts.app')
@section('title', 'Wallet')
@section('wallet_active', 'active')
@section('content')
    <div class="wallet mt-3">
        <div class="card wallet_card mb-3 shadow">
            <div class="card-body">
                <div class="mb-3">
                    <span>Balance</span>
                    <h4>{{ number_format($user->wallet ? $user->wallet->amount : '-') }} <span>MMK</span></h4>
                </div>
                <div class="mb-3">
                    <span>Account Number</span>
                    <h4>{{ $user->wallet ? $user->wallet->account_number : '-' }}</h4>
                </div>
                <div class="mb-3">
                    <span>{{ $user->name }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
