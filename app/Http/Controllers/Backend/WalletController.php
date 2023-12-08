<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class WalletController extends Controller
{
    public function index()
    {
        return view('backend.wallet.index');
    }
    public function ssd()
    {
        $wallet = Wallet::with('user');
        return DataTables::of($wallet)
            ->addColumn('account_owner', function ($each) {
                if ($each->user) {
                    $user = $each->user;
                    return '<p>name: ' . $user->name . '</p>' . '<p>email: ' . $user->email . '</p>' . '<p>phone: ' . $user->phone . '</p>';
                }
                return '-';
            })
            ->editColumn('amount', function ($each) {
                return number_format($each->amount, 2);
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('created_at', function ($each) {
                return Carbon::parse($each->created_at)->format('d/m/Y H:i:s');
            })
            ->rawColumns(['account_owner'])
            ->toJson();
    }
}
