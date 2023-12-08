<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->ip = $request->ip();
        $user->user_agent = $request->server('HTTP_USER_AGENT');
        $user->login_at = now();
        $user->save();
        Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'account_number' => UUIDGenerate::generateNumber(),
                'amount' => 0,
            ],
        );

        $token = $user->createToken('Magic Pay')->plainTextToken;
        return success('successfully register', ['token' => $token]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->tokens()) {
                $user->tokens()->delete();
            }
            $token = $user->createToken('Magic Pay')->plainTextToken;
            return success('Successfully login', ['token' => $token]);
        }
        return fail('These credentials do not match our records.', null);
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user->tokens()) {
            $user->tokens()->delete();
        }
        return success('success', 'Logout');
    }
}
