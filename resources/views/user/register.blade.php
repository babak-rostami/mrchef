@extends('layouts.app')

@section('title', 'ثبت نام')

@push('styles')
    @vite('resources/css/user/register.css')
@endpush

@section('content')
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-xl p-6">

                <h2 class="text-center text-xl font-semibold mb-6">ثبت نام در سایت</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- نام --}}
                    <div class="mb-4">
                        <label for="name" class="block mb-1 text-sm font-medium">نام کامل</label>
                        <input type="text" id="name" name="name"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ایمیل --}}
                    <div class="mb-4">
                        <label for="email" class="block mb-1 text-sm font-medium">ایمیل</label>
                        <input type="email" id="email" name="email"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- پسورد --}}
                    <div class="mb-4">
                        <label for="password" class="block mb-1 text-sm font-medium">رمز عبور</label>
                        <input type="password" id="password" name="password"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none @error('password') border-red-500 @enderror"
                            required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- تکرار پسورد --}}
                    <div class="mb-6">
                        <label for="password_confirmation" class="block mb-1 text-sm font-medium">تکرار رمز عبور</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none" required>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition cursor-pointer">
                        ثبت نام
                    </button>

                    <div class="text-center mt-4">
                        <small class="text-sm">
                            قبلاً ثبت‌نام کرده‌اید؟
                            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">وارد شوید</a>
                        </small>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
