@extends('frontend.layouts.app')
@section('title', 'Transaction Detail')
@section('history_active', 'active')
@section('content')
    <div class="transaction_datail">
        <div class="card mb-5">
            <div class="card-body p-3">
                <div class="text-center mb-5">
                    <img src="{{ asset('img/checked.png') }}" alt="">
                    @if ($transaction->type == 2)
                        <h5 class="text-danger mt-3">-{{ number_format($transaction->amount) }} MMK</h5>
                    @elseif($transaction->type == 1)
                        <h5 class="text-success mt-3">+{{ number_format($transaction->amount) }} MMK</h5>
                    @endif
                </div>
                @if (session('transfer_success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('transfer_success') }}
                    </div>
                @endif
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">{{ $transaction->type == 1 ? 'From' : 'To' }}</p>
                    <p class="text-muted mb-0">
                        {{ $transaction->sourceUser ? $transaction->sourceUser->name : '' }}
                    </p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">Phone</p>
                    <p class="text-muted mb-0">
                        {{ $transaction->sourceUser ? $transaction->sourceUser->phone : '' }}
                    </p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">Trx Id</p>
                    <p class="text-muted mb-0">
                        {{ $transaction->trx_id }}
                    </p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">Refrence No.</p>
                    <p class="text-muted mb-0">
                        {{ $transaction->ref_no }}
                    </p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">Type</p>
                    @if ($transaction->type == 1)
                        <p class="mb-0 badge text-bg-success">Income</p>
                    @elseif($transaction->type == 2)
                        <p class="mb-0 badge text-bg-danger">Expense</p>
                    @endif
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">Description</p>
                    <p class="text-muted mb-0">
                        {{ $transaction->description }}
                    </p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">Date</p>
                    <p class="text-muted mb-0">
                        {{ $transaction->created_at->format('d-M-Y H:m:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
