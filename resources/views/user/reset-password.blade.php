@extends('layouts.app')

@section('title', 'تغییر رمز عبور')

@section('content')

    <x-partials.breadcrumb panel="user" page="تغییر رمز عبور" />

    <div class="flex justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6 md:p-8">

            <h1 class="text-xl font-bold text-center mb-6">
                تغییر رمز عبور
            </h1>

            <div id="reset-password-form" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div>
                    <label class="block text-sm mb-1">ایمیل</label>
                    <input type="email" name="email" id="auth-reset-email-input"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="example@email.com">
                </div>

                <!-- Password -->
                <div class="relative">
                    <label class="block text-sm mb-1">رمز جدید</label>
                    <input type="password" name="password" id="auth-reset-password-input"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="رمز جدید">

                    <button type="button" class="absolute left-3 top-9 text-gray-500" id="auth-reset-password-toggle">
                        🙈
                    </button>
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <label class="block text-sm mb-1">تکرار رمز جدید</label>
                    <input type="password" name="password_confirmation" id="auth-reset-password2-input"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="تکرار رمز جدید">

                    <button type="button" class="absolute left-3 top-9 text-gray-500" id="auth-reset-password2-toggle">
                        🙈
                    </button>
                </div>

                <!-- Submit -->
                <span id="auth-reset-error"
                    class="w-full bg-red-600 text-white py-2 rounded-2xl text-2xl block
           text-center hidden mb-0">
                </span>

                <button type="submit" id="auth-reset-btn"
                    class="w-full bg-blue-600 text-white py-2 rounded-2xl text-2xl
                       hover:bg-blue-700 transition disabled:bg-blue-400 disabled:cursor-not-allowed
                       cursor-pointer">
                    تغییر رمز عبور
                    <img class="inline" src="{{ asset('files/icon/arrow-left-24.png') }}">
                </button>
            </div>

        </div>
    </div>

@endsection


@section('scripts')
    @vite(['resources/js/user/reset-password.js'])
@endsection
