<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        return view('backend.transaction.index');
    }
    public function ssd()
    {
        $transaction = Transaction::with('user', 'sourceUser')->where('type', 1);
        return DataTables::of($transaction)
            ->addColumn('transfer_name', function ($each) {
                return $each->user->name;
            })
            ->addColumn('receive_name', function ($each) {
                return $each->sourceUser->name;
            })
            ->editColumn('created_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('d-m-Y H:i:s');
            })
            ->editColumn('amount', function ($each) {
                return number_format($each->amount, 2) . " MMK";
            })
            ->toJson();
    }
}
