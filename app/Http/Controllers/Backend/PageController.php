<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Transaction;
use App\Models\User;

class PageController extends Controller
{
    public function home()
    {
        $users = User::all();
        $admin_users = AdminUser::all();
        $transactions = Transaction::all();

        $total_amount = 0;
        $total_transaction_amount = 0;
        foreach ($users as $user) {
            $total_amount += $user->wallet->amount;
        }
        foreach ($transactions as $transaction) {
            $total_transaction_amount += $transaction->amount;
        }
        return view('backend.home', compact('users', 'admin_users', 'total_amount', 'total_transaction_amount'));
    }
}
