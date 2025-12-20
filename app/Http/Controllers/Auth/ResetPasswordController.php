<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showForm(string $token)
    {
        return view('user.reset-password', [
            'token' => $token
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ], [
            'email.required' => 'وارد کردن ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل صحیح نیست',
            'password.required' => 'وارد کردن رمز عبور الزامی است',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد',
            'password.confirmed' => 'تکرار رمز عبور یکسان نمی باشد',
            'token.required' => 'توکن بازیابی رمز عبور الزامی است'
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function (User $user, string $password) {
                $user->update([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60)
                ]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'رمز عبور با موفقیت تغییر کرد');
            return response()->json([
                'message' => 'رمز عبور با موفقیت تغییر کرد',
                'redirect' => url('/')
            ]);
        }

        return response()->json([
            'errors' => [
                'token' => ['توکن نامعتبر یا منقضی شده است']
            ]
        ], 422);
    }
}
