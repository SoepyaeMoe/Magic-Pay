@extends('frontend.layouts.app')
@section('title', 'Transaction History')
@section('history_active', 'active')
@section('content')
    <div class="transaction mt-3 mb-3">
        <div class="row justify-content-between mb-3">
            <div class="col-6"></div>
            <div class="col-6">
                <div class="input-group">
                    <label class="input-group-text p-1" for="inputGroupSelect01">Type</label>
                    <select class="form-select p-1 type" id="inputGroupSelect01">
                        <option value="">All</option>
                        <option value="1" {{ request()->type == 1 ? 'selected' : '' }}>Income</option>
                        <option value="2" {{ request()->type == 2 ? 'selected' : '' }}>Expense</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="infinite-scroll">
            @foreach ($transactions as $transaction)
                <a href="{{ route('transaction.detail', $transaction->trx_id) }}">
                    <div class="card mb-1">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Trx Id: <span class="text-muted">{{ $transaction->trx_id }}</span></p>
                                <p
                                    class="mb-2 @if ($transaction->type == 2) text-danger @elseif($transaction->type == 1) text-success @endif">
                                    @if ($transaction->type == 2)
                                        -
                                    @elseif($transaction->type == 1)
                                        +
                                    @endif
                                    {{ number_format($transaction->amount) }} <small>MMK</small>
                                </p>
                            </div>
                            <div>
                                <p class="mb-0">
                                    @if ($transaction->type == 2)
                                        To
                                    @elseif($transaction->type == 1)
                                        From
                                    @endif
                                </p>
                                <p class="mb-0 text-muted">
                                    @if ($transaction->sourceUser)
                                        {{ $transaction->sourceUser->name }}
                                        ({{ $transaction->sourceUser->phone }})
                                    @endif
                                </p>
                                <p class="mb-0 text-muted">{{ $transaction->created_at->format('d-M-Y H:m:i') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div><small class="ms-2">Loading.....</small>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
        $(document).ready(function() {
            $('.type').change(function() {
                let type = $('.type').val();
                let currentUrl = window.location.href;
                let url = new URL(currentUrl);
                url.searchParams.set('type', type);
                window.location.href = url;
            })
        })
    </script>
@endsection
