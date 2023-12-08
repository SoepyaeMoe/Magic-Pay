@extends('backend.layouts.app')
@section('title', 'Transaction')
@section('transaction-active', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaction<span class="badge bg-primary"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="overflow-x: auto;">
            <table class="table table-striped table-hover table-bordered" id="transaction" style="width: 100%;">
                <thead class="bg-light">
                    <tr>
                        <th>Ref NO.</th>
                        <th>Trx Id</th>
                        <th>Transfer Name</th>
                        <th>Receive Name</th>
                        <th>Amount(MMK)</th>
                        <th>Description</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new DataTable('#transaction', {
            ajax: 'transaction/datatable/ssd',
            processing: true,
            serverSide: true,
            columns: [{
                    data: 'ref_no',
                    name: 'ref_no',
                    sortable: false
                },
                {
                    data: 'trx_id',
                    name: 'trx_id',
                    sorable: false
                },
                {
                    data: 'transfer_name',
                    name: 'transfer_name',
                    searchable: true
                },
                {
                    data: 'receive_name',
                    name: 'receive_name',
                    searchable: true
                },
                {
                    data: 'amount',
                    name: 'amount',
                    searchable: true
                },
                {
                    data: 'description',
                    name: 'description',
                    searchable: true
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: true
                }

            ],
            order: [6, 'desc']
        });
    </script>
@endsection
