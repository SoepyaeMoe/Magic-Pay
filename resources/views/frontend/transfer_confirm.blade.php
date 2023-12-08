@extends('frontend.layouts.app')
@section('title', 'Transfer Confirm')
@section('home_active', 'active')

@section('content')
    <div class="transfer mt-3">
        @include('frontend.layouts.flash')
        <div class="card">
            <form action="{{ route('transfer.complete') }}" method="POST" id="form">
                @csrf
                <input type="hidden" name="to_phone" value="{{ $to_phone }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="description" value="{{ $description }}">
                <input type="hidden" name="hash_value" value="{{ $hash_value }}">

                <div class="card-body">
                    <div class="mb-3">
                        <label class="mb-0"><strong>From</strong></label>
                        <p class="text-muted mb-0">{{ $user->name }}</p>
                        <p class="text-muted mb-0">{{ $user->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="to_phone">To</label>
                        <p class="text-muted mb-0">{{ $toUser->name }}</p>
                        <p class="text-muted mb-0">{{ $toUser->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="amount">Amount</label>
                        <p class="text-muted">{{ number_format($amount) }} MMK</p>
                    </div>
                    <div class="mb-3">
                        <label for="description">Description</label>
                        <p class="text-muted">{{ $description }}</p>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-theme confirm_btn" style="width: 100%;">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.confirm_btn').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '<p class="h5">Confirm Password</p>',
                    html: `<input type="password" class="form-control text-center password"/>`,
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    cancelButtonAriaLabel: "Thumbs down"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let password = $('.password').val();
                        $.ajax({
                            url: '/password-check?password=' + password,
                            method: 'GET',
                            success: function(response) {
                                if (response.status == 'success') {
                                    $('#form').submit();
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: response.message,
                                    });
                                }
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
