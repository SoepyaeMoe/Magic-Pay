<?php

namespace App\Helpers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class UUIDGenerate
{
    public static function generateNumber()
    {
        $account_number = mt_rand(1000000000000000, 9999999999999999);
        if (DB::table('wallets')->where('account_number', $account_number)->exists()) {
            self::generateNumber();
        }
        return $account_number;
    }
    public static function refNumber()
    {
        $number = mt_rand(1000000000000000, 9999999999999999);
        if (Transaction::where('ref_no', $number)->exists()) {
            self::refNumber();
        }
        return $number;
    }
    public static function trxId()
    {
        $number = mt_rand(1000000000000000, 9999999999999999);
        if (Transaction::where('ref_no', $number)->exists()) {
            self::trxId();
        }
        return $number;
    }
}
