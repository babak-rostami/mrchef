@extends('layouts.app')

@section('title', 'داشبورد')

@push('styles')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')

    <div class="mx-auto mb-6 px-4">
        <h3 class="text-center mb-6 font-bold text-xl">داشبورد مدیریت</h3>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-center">

            <!-- دسته بندی‌ها -->
            <a href="{{ route('category.index') }}" class="block">
                <div class="bg-white shadow p-5 rounded-2xl hover:shadow-lg transition cursor-pointer text-center">
                    <div class="text-4xl text-indigo-600 mb-3">
                        <i class="fa-solid fa-list"></i>
                    </div>
                    <h5 class="font-bold">دسته‌بندی‌ها</h5>
                    <p class="text-gray-500 text-sm mt-2">مدیریت دسته‌بندی‌ها</p>
                </div>
            </a>

            <!-- پست‌ها -->
            <a href="{{ route('recipes.index') }}" class="block">
                <div class="bg-white shadow p-5 rounded-2xl hover:shadow-lg transition cursor-pointer text-center">
                    <div class="text-4xl text-blue-600 mb-3">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h5 class="font-bold">رسپی‌ها</h5>
                    <p class="text-gray-500 text-sm mt-2">مدیریت رسپی ها</p>
                </div>
            </a>

            <!-- سوالات -->
            <a href="" class="block">
                <div class="bg-white shadow p-5 rounded-2xl hover:shadow-lg transition cursor-pointer text-center">
                    <div class="text-4xl text-yellow-600 mb-3">
                        <i class="fa-solid fa-circle-question"></i>
                    </div>
                    <h5 class="font-bold">سوالات</h5>
                    <p class="text-gray-500 text-sm mt-2">مدیریت پرسش‌ها</p>
                </div>
            </a>

            <!-- کاربران -->
            <a href="" class="block">
                <div class="bg-white shadow p-5 rounded-2xl hover:shadow-lg transition cursor-pointer text-center">
                    <div class="text-4xl text-green-600 mb-3">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h5 class="font-bold">کاربران</h5>
                    <p class="text-gray-500 text-sm mt-2">مدیریت کاربران</p>
                </div>
            </a>

        </div>
    </div>

@endsection
