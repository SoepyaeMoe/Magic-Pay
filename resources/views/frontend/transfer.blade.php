@extends('frontend.layouts.app')
@section('title', 'Transfer')
@section('home_active', 'active')

@section('content')
    <div class="transfer mt-3">
        @include('frontend.layouts.flash')
        <div class="card">
            <form action="{{ route('transfer.confirm') }}" method="get" id="transfer_form">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="mb-0"><strong>From</strong></label>
                        <p class="text-muted mb-0">{{ $user->name }}</p>
                        <p class="text-muted mb-0">{{ $user->phone }}</p>
                    </div>
                    <input type="hidden" name="hash_value" class="hash_value">
                    <div class="mb-3">
                        @if (!empty($to_phone))
                            <label for="to_phone">To <span
                                    class="to_account text-success me-3">({{ $to_user->name }})</span></label>
                            <div class="input-group">
                                <input type="number" name="to_phone" class="form-control to_phone"
                                    value="{{ $to_phone }}" readonly>
                                <span class="input-group-text check_verify_btn"><i class='bx bx-check'></i></span>
                            </div>
                        @else
                            <label for="to_phone">To <span class="to_account text-success me-3"></span></label>
                            <div class="input-group">
                                <input type="number" name="to_phone" class="form-control to_phone"
                                    value="{{ old('to_phone') }}" placeholder="Enter digits">
                                <span class="input-group-text check_verify_btn"><i class='bx bx-check'></i></span>
                            </div>
                        @endif
                        @error('to_phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount">Amount (MMK)</label>
                        <input type="number" name="amount" class="form-control amount" value="{{ old('amount') }}"
                            placeholder="Enter amount">
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control description" placeholder="Description"></textarea>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-theme submit_btn" style="width: 100%;">Continute</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let phone = document.getElementsByClassName('to_phone')[0];
        $(document).ready(function() {
            $('.check_verify_btn').on('click', function() {
                $.ajax({
                    url: 'check-verify-account?phone=' + phone.value,
                    method: 'GET',
                    success: function(response) {
                        $('.to_account').text('');
                        if (response.status == "success") {
                            $('.to_account').append('(' + response.data['name'] + ')');
                        } else {
                            $('.to_account').append(response.message);
                        }
                    }
                });
            });
            $('.submit_btn').on('click', function(e) {
                e.preventDefault();
                var to_phone = $('.to_phone').val();
                var amount = $('.amount').val();
                var description = $('.description').val();
                $.ajax({
                    url: `transfer-check?to_phone=${to_phone}&amount=${amount}&description=${description}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.status == 'success') {
                            $('.hash_value').val(response.data);
                            $('#transfer_form').submit();
                        }
                    }
                });
            });
        });
    </script>
@endsection
