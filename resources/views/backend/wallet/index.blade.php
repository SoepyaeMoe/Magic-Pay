@extends('backend.layouts.app')
@section('title', 'Wallet')
@section('wallet-active', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Wallet<span class="badge bg-primary"></h1>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('backend.flash') --}}
    <div class="card">
        <div class="card-body" style="overflow-x: auto;">
            <table class="table table-striped table-hover table-bordered" id="wallet" style="width: 100%;">
                <thead class="bg-light">
                    <tr>
                        <th>Account Number</th>
                        <th>Accont Owner</th>
                        <th>Amount(MMK)</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new DataTable('#wallet', {
            ajax: 'wallet/datatable/ssd',
            processing: true,
            serverSide: true,
            columns: [{
                    data: 'account_number',
                    name: 'account_number'
                },
                {
                    data: 'account_owner',
                    name: 'account_owner'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }

            ],
            order: [4, 'desc']
        });
    </script>
@endsection
