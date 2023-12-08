<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\Http\Requests\transferConfirm;
use App\Http\Requests\UpadatePassword;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    public function home()
    {
        $user = Auth::guard('web')->user();
        return view('frontend.home', compact('user'));
    }
    public function profile()
    {
        $user = Auth::user();
        return view('frontend.profile', compact('user'));
    }
    public function updatePassword()
    {
        return view('frontend.update_password');
    }
    public function updatePasswordStore(UpadatePassword $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $confirm_password = $request->confirm_password;
        $user = Auth::guard('web')->user();
        if (Hash::check($old_password, $user->password)) {
            if ($new_password === $confirm_password) {
                $user->password = Hash::make($new_password);
                $user->update();

                $title = 'Password change';
                $message = 'Your account password was successfully changed';
                $sourceable_id = $user->id;
                $sourceable_type = User::class;
                $web_link = url('profile');
                $deep_link = [
                    'target' => 'profile',
                    'parameter' => null,
                ];

                Notification::send($user, new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

                return redirect()->route('profile')->with('update', 'Successfully Updated');
            } else {
                return back()->withErrors(['confirm_password' => 'Confirm password not match.'])->withInput();
            }
        } else {
            return back()->withErrors(['old_password' => 'Old password is not correct.'])->withInput();
        }
    }
    public function wallet()
    {
        $user = Auth::guard('web')->user();
        return view('frontend.wallet', compact('user'));
    }

    public function transfer(Request $request)
    {
        $user = Auth::guard('web')->user();
        if ($request->to_phone) {
            $to_phone = $request->to_phone;
            $str = $to_phone;
            $hash_value = hash_hmac('sha256', $str, 'magic_pay1234!@#$', $binary = false);
            $to_user = User::select('name', 'phone')->where('phone', $to_phone)->first();
            if (!$to_user) {
                return back()->withErrors(['fail' => 'Unknown user']);
            }
            if ($to_phone == $user->phone) {
                return back()->withErrors(['fail' => 'Invalid QR']);
            }
            return view('frontend.transfer', compact('user', 'to_phone', 'to_user', 'hash_value'));

        }
        return view('frontend.transfer', compact('user'));
    }

    public function transferConfirm(transferConfirm $request)
    {
        $user = Auth::guard('web')->user();
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $wonAmount = $user->wallet->amount;
        $toUser = User::select('phone', 'name')->where('phone', $to_phone)->first();

        $str = $request->to_phone . $request->amount . $request->description;
        $hash_value = hash_hmac('sha256', $str, 'magic_pay1234!@#$', $binary = false);

        if ($hash_value !== $request->hash_value) {
            return back()->withErrors(['fail' => 'Transfer fail.Somethings went wroung'])->withInput();
        }

        if ($amount < 1000) {
            return back()->withErrors(['amount' => 'Minimun transition amount should be 1000.00 MMK'])->withInput();
        }
        if ($to_phone == $user->phone || empty($toUser)) {
            return back()->withErrors(['to_phone' => 'Invalid number'])->withInput();
        }
        if ($amount > $wonAmount) {
            return back()->withErrors(['amount' => 'Not enough money.You have only ' . $wonAmount . ' MMK'])->withInput();
        }

        return view('frontend.transfer_confirm', compact('user', 'to_phone', 'amount', 'description', 'toUser', 'hash_value'));
    }

    public function transferComplete(transferConfirm $request)
    {
        $user = Auth::guard('web')->user();
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $toUser = User::where('phone', $to_phone)->first();
        $wonAmount = $user->wallet->amount;

        $str = $request->to_phone . $request->amount . $request->description;
        $hash_value = hash_hmac('sha256', $str, 'magic_pay1234!@#$', $binary = false);

        if ($hash_value !== $request->hash_value) {
            return back()->withErrors(['fail' => 'Transfer fail.Somethings went wroung'])->withInput();
        }

        if ($amount < 1000) {
            return back()->withErrors(['fail' => 'Minimun transition amount should be 1000.00 MMK'])->withInput();
        }
        if ($to_phone == $user->phone || empty($toUser)) {
            return back()->withErrors(['fail' => 'Invalid number'])->withInput();
        }
        if (empty($toUser->wallet) || empty($user->wallet)) {
            return back()->withErrors(['fail' => 'Something wroung!']);
        }
        if ($amount > $wonAmount) {
            return back()->withErrors(['fail' => 'Not enough money.'])->withInput();
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
            return redirect('/transaction/detail/' . $trx_id)->with('transfer_success', 'Successfully transfered.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['fail' => 'Transfer failed, Something went wroung!' . $e->getMessage()]);
        }
    }

    public function transaction(Request $request)
    {
        $user = Auth::guard('web')->user();
        $transactions = Transaction::with('user', 'sourceUser')
            ->orderBy('created_at', 'desc')
            ->where('user_id', $user->id);

        if ($request->type) {
            $transactions = $transactions->where('type', $request->type);
        }
        $transactions = $transactions->paginate(5);
        return view('frontend.transaction', compact('transactions', 'user'));
    }
    public function transactionDetail($trx_id)
    {
        $user = Auth::guard('web')->user();
        $transaction = Transaction::with('user', 'sourceUser')
            ->where('trx_id', $trx_id)->where('user_id', $user->id)
            ->first();
        if ($transaction) {
            return view('frontend.transaction_datail', compact('user', 'transaction'));
        } else {
            return abort(404);
        }
    }

    public function myQr()
    {
        $user = Auth::guard('web')->user();
        return view('frontend.my_qr', compact('user'));
    }

    public function scanToPay()
    {
        return view('frontend.scan_to_pay');
    }

    // ajax json response
    public function passwordCheck(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (empty($request->password)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please fill your password',
            ]);
        }
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Wroung password, try again!',
            ]);
        }
    }

    public function checkVerifyAccount(Request $request)
    {
        $phone = $request->phone;
        $authUser = Auth::guard('web')->user();
        $user = User::select('name')->where('phone', $phone)->first();
        if ($phone != $authUser->phone) {
            if (!empty($user)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $user,
                ]);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => '<span class="text-danger">(User not found.)</span>',
                ]);
            }

        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '<span class="text-danger">(Invalid number)</span>',
            ]);
        }
    }

    public function transferCheck(Request $request)
    {
        $str = $request->to_phone . $request->amount . $request->description;
        $hash_value = hash_hmac('sha256', $str, 'magic_pay1234!@#$', $binary = false);
        return response()->json([
            'status' => 'success',
            'data' => $hash_value,
        ]);
    }
}
