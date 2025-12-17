@extends('layouts.app')

@section('title', 'ورود')

@section('styles')
    @vite(['resources/css/user/login.css'])
@endsection

@section('content')

    <div class="flex justify-center">
        <div class="w-full max-w-md">

            <div class="bg-white shadow rounded-2xl p-6">
                <h4 class="text-center mb-6 font-semibold text-lg">ورود به حساب کاربری</h4>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block mb-1 font-medium">ایمیل</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-300 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block mb-1 font-medium">رمز عبور</label>
                        <input id="password" type="password" name="password" required
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-300 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex justify-between items-center mb-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded">
                            <span>من را به خاطر بسپار</span>
                        </label>
                        <a href="#" class="text-indigo-600 hover:underline text-sm">فراموشی رمز؟</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl transition cursor-pointer">
                        ورود
                    </button>

                    <!-- Register -->
                    <div class="text-center mt-3">
                        <small>
                            حسابی ندارید؟
                            <a href="{{ route('register.show') }}" class="text-indigo-600 hover:underline">
                                ثبت‌نام کنید
                            </a>
                        </small>
                    </div>
                </form>

            </div>

        </div>
    </div>

@endsection
