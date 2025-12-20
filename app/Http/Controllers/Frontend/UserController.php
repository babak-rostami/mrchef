<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\LoginRequest;
use App\Http\Requests\user\RegisterRequest;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function registerShow()
    {
        return view('user.register');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'ثبت نام با موفقیت انجام شد'
        ]);
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

        if (Auth::attempt($credentials, 1)) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'ایمیل یا رمز عبور اشتباه است.'
        ], 401);
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

    public function checkEmailExist(Request $request)
    {
        // ایمیل وارد کرده؟
        if (! $request->filled('email')) {
            return response()->json([
                'message' => 'ایمیل خود را وارد کنید'
            ], 422);
        }

        // فرمت ایمیل
        if (! filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'فرمت ایمیل معتبر نیست'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'username' => $user->username
            ]);
        } else {
            return response()->json([
                'exists' => false
            ]);
        }
    }

    // public function forgot(Request $request)
    // {
    //     // ایمیل وارد کرده؟
    //     if (! $request->filled('email')) {
    //         return response()->json([
    //             'message' => 'ایمیل خود را وارد کنید'
    //         ], 422);
    //     }

    //     // فرمت ایمیل
    //     if (! filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
    //         return response()->json([
    //             'message' => 'فرمت ایمیل معتبر نیست'
    //         ], 422);
    //     }

    //     $user = User::where('email', $request->email)->first();

    //     if (! $user) {
    //         return response()->json([
    //             'message' => 'کاربری با این ایمیل وجود ندارد'
    //         ], 404);
    //     }

        

    //     // ارسال ایمیل بازیابی رمز عبور (اینجا فقط شبیه‌سازی شده)
    //     Mail::to($user->email)->send(new ForgotPasswordMail($route));

    //     return response()->json([
    //         'message' => 'ایمیل بازیابی رمز عبور ارسال شد'
    //     ]);
    // }

}
