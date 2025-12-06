<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\LoginRequest;
use App\Http\Requests\user\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function registerShow()
    {
        return view('user.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        //خودش سشن آی دی رو regenerate میکنه لازم نیست
        Auth::login($user);

        return redirect()->route('home')->with('success', 'ثبت نام با موفقیت انجام شد');
    }

    public function loginShow()
    {
        return view('user.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'با موفقیت وارد شدید!');
        }

        return back()
            ->withErrors([
                'email' => 'ایمیل یا رمز عبور اشتباه است.',
            ])
            ->withInput($request->only('email'));
    }


    public function logout(Request $request)
    {
        //ستون user_id در سشن پاک می‌شه ولی خود سشن هنوز فعاله
        //کوکی remember me را هم حذف می‌کنه
        Auth::logout();
        // سشن فعلی رو کامل پاک می‌کنه
        $request->session()->invalidate();

        // یه سشن جدید درست میکنه و _token جدید رو ایجاد میکنه
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'از حساب کاربری خود خارج شدید.');
    }
}
