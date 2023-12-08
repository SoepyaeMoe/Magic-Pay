<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\transferConfirm;
use App\Http\Resources\ProfileResource;
use App\Notifications\GeneralNotification;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\TransactionDetailResource;
use App\Http\Resources\NotificationDetailResource;

class PageController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $data = new ProfileResource($user);
        return success('success', ['data' => $data]);
    }
    public function transaction(Request $request)
    {
        $user = Auth::user();
        $transactions = Transaction::with('user', 'sourceUser')
            ->orderBy('updated_at', 'desc')
            ->where('user_id', $user->id);
        if ($request->type) {
            $transactions->where('type', $request->type);
        }
        $transactions = $transactions->paginate(5);
        $data = TransactionResource::collection($transactions)->additional(['result' => 1, 'message' => 'success']);
        return $data;
    }
    public function transactionDetail($trx_id)
    {
        $user = Auth::user();
        $transactions = Transaction::with('user', 'sourceUser')
            ->where('trx_id', $trx_id)
            ->where('user_id', $user->id)->firstOrFail();
        $data = new TransactionDetailResource($transactions);
        return success('success', $data);
    }
    public function notification()
    {
        $user = Auth::user();
        $noti = $user->notifications()->paginate(5);
        $data = NotificationResource::collection($noti)->additional(['result' => 1, 'message' => 'success']);
        return $data;
    }
    public function notificationDetail($id)
    {
        $user = Auth::user();
        $noti = $user->notifications()->where('id', $id)->firstOrFail();
        $noti->markAsRead();
        $data = new NotificationDetailResource($noti);
        return success('success', $data);
    }
    public function checkVerfiy(Request $request)
    {
        $authUser = Auth::user();

        if ($request->phone) {
            if ($request->phone != $authUser->phone) {
                $user = User::where('phone', $request->phone)->first();
                if (!empty($user)) {
                    return success('success', [
                        'name' => $user->name,
                        'phone' => $user->phone,
                    ]);
                }
                return fail('User not found', null);
            }
            return fail('Invalid number', null);
        }
    }

    public function transferConfirm(transferConfirm $request)
    {
        $user = Auth::user();
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $wonAmount = $user->wallet->amount;
        $toUser = User::select('phone', 'name')->where('phone', $to_phone)->first();

        $str = $request->to_phone . $request->amount . $request->description;
        $hash_value = hash_hmac('sha256', $str, 'magic_pay1234!@#$', $binary = false);

        if ($hash_value != $request->hash_value) {
            return fail('Transfer fail.Something went wroung', null);
        }

        if ($amount < 1000) {
            return fail('Minimun transition amount should be 1000.00 MMK', null);
        }
        if ($to_phone == $user->phone || empty($toUser)) {
            return fail('Invalid number');
        }
        if ($amount > $wonAmount) {
            return fail('Not enough money.You have only ' .$wonAmount.' MMK', null);
        }

        return success('success', [
            'from_name' => $user->name,
            'from_phone' => $user->phone,
            'to_name' => $toUser->name,
            'to_phone' => $toUser->phone,
            'amount' => number_format($amount),
            'description' => $description,
            'hash_value' => $hash_value
        ]);
    }

    public function transferComplete(transferConfirm $request)
    {
        $user = Auth::user();
        if (empty($request->password)) {
            return fail('Please fill your password', null);
        }
        if (!Hash::check($request->password, $user->password)) {
            return fail('Wroung password, try again!', null);
        }


        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $toUser = User::where('phone', $to_phone)->first();
        $wonAmount = $user->wallet->amount;

        $str = $request->to_phone . $request->amount . $request->description;
        $hash_value = hash_hmac('sha256', $str, 'magic_pay1234!@#$', $binary = false);

        if ($hash_value !== $request->hash_value) {
            return fail('Transfer fail.Something went wroung', null);
        }

        if ($amount < 1000) {
            return fail('minimun transaction amount should be 1000.00 MMK');
        }
        if ($to_phone == $user->phone || empty($toUser)) {
            return fail('Invalid number');
        }
        if (empty($toUser->wallet) || empty($user->wallet)) {
            return fail('Something wroung', null);
        }
        if ($amount > $wonAmount) {
            return fail('Not enough money');
        }
        DB::beginTransaction();
        try {
            $user->wallet->decrement('amount', $amount);
            $user->update();
            $toUser->wallet->increment('amount', $amount);
            $toUser->update();

            $ref_no = UUIDGenerate::refNumber();
            $trx_id = UUIDGenerate::trxId();
            $transaction = new Transaction;
            $transaction->ref_no = $ref_no;
            $transaction->trx_id = $trx_id;
            $transaction->user_id = $user->id;
            $transaction->type = 2;
            $transaction->amount = $amount;
            $transaction->source_id = $toUser->id;
            $transaction->description = $description;
            $transaction->save();

            $to_trx_id = UUIDGenerate::trxId();
            $transaction = new Transaction;
            $transaction->ref_no = $ref_no;
            $transaction->trx_id = $to_trx_id;
            $transaction->user_id = $toUser->id;
            $transaction->type = 1;
            $transaction->amount = $amount;
            $transaction->source_id = $user->id;
            $transaction->description = $description;
            $transaction->save();

            // from noti
            $title = 'Money Transfered!';
            $message = 'You transdered ' . number_format($amount) . ' MMK form your wallet to ' . $toUser->name . ' (' . $toUser->phone . ')';
            $sourceable_id = $trx_id;
            $sourceable_type = User::class;
            $web_link = url('/transaction/detail/' . $trx_id);
            $deep_link = [
                'target' => 'transaction/detail',
                'parameter' => [
                    'id' => $trx_id,
                ],
            ];
            Notification::send($user, new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

            // to noti
            $title = 'Money Received!';
            $message = 'You received ' . number_format($amount) . ' MMK from ' . $user->name . ' (' . $user->phone . ')';
            $sourceable_id = $to_trx_id;
            $sourceable_type = User::class;
            $web_link = url('/transaction/detail/' . $to_trx_id);
            $deep_link = [
                'target' => 'transaction/detail',
                'parameter' => [
                    'id' => $to_trx_id,
                ],
            ];

            Notification::send($toUser, new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

            DB::commit();
            return success('Successfully transfered', [
                'trx_id' => $trx_id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return fail('Transfer fail.Something went wroung', null);
        }
    }

    public function transfer(Request $request) {
       if($request->to_phone){
            $user = Auth::user();
            $toUser = User::where('phone', $request->to_phone)->first();
            if(empty($toUser) || $toUser->phone == $user->phone){
                return fail('Invalid QR', null);
            }
            return success('success', [
                'from_name' => $user->name,
                'from_phone' => $user->phone,
                'to_name' => $toUser->name,
                'to_phone' => $toUser->phone,
            ]);
       }
    }
}
