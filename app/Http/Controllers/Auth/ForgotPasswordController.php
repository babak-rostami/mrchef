<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return match ($status) {
            Password::RESET_LINK_SENT => response()->json(['message' => 'ایمیل بازیابی رمز عبور ارسال شد']),
            Password::RESET_THROTTLED => response()->json(['message' => 'لطفاً یک دقیقه صبر کنید و دوباره تلاش کنید'], 429),
            default => response()->json(['message' => 'حسابی با این ایمیل ثبت نشده'], 404),
        };
    }
}
