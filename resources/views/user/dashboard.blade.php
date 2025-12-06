@extends('layouts.app')

@section('title', 'داشبورد')

@push('styles')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')

    <div class="mb-40 md:mx-8 lg:mx-44">
        <h3 class="text-center mb-6 font-bold text-2xl">داشبورد مدیریت</h3>

        <div class="grid grid-cols-2 gap-6 justify-center">

            <!-- دسته بندی‌ها -->
            <a href="{{ route('admin.category.index') }}" class="block">
                <div
                    class="bg-white shadow p-5 rounded-2xl hover:scale-105 duration-300 cursor-pointer flex flex-col items-center gap-2">
                    <img src="{{ asset('files/icon/category-48.png') }}" alt="">
                    <h5 class="font-bold">دسته بندی</h5>
                    <p class="text-gray-500 text-sm">مدیریت دسته بندی</p>
                </div>
            </a>

            <!-- رسپی ها -->
            <a href="{{ route('admin.recipes.index') }}" class="block">
                <div
                    class="bg-white shadow p-5 rounded-2xl hover:scale-105 duration-300 cursor-pointer flex flex-col items-center gap-2">
                    <img src="{{ asset('files/icon/recipe-48.png') }}" alt="">
                    <h5 class="font-bold">رسپی‌ها</h5>
                    <p class="text-gray-500 text-sm">مدیریت رسپی ها</p>
                </div>
            </a>

            <!-- مواد اولیه -->
            <a href="{{ route('admin.ingredient.index') }}" class="block">
                <div
                    class="bg-white shadow p-5 rounded-2xl hover:scale-105 duration-300 cursor-pointer flex flex-col items-center gap-2">
                    <img src="{{ asset('files/icon/ingredient-48.png') }}" alt="">
                    <h5 class="font-bold">مواد اولیه</h5>
                    <p class="text-gray-500 text-sm">مدیریت مواد اولیه</p>
                </div>
            </a>

            <!-- واحد ها -->
            <a href="{{ route('admin.unit.index') }}" class="block">
                <div
                    class="bg-white shadow p-5 rounded-2xl hover:scale-105 duration-300 cursor-pointer flex flex-col items-center gap-2">
                    <img src="{{ asset('files/icon/units-48.png') }}" alt="">
                    <h5 class="font-bold">واحد های اندازه گیری</h5>
                    <p class="text-gray-500 text-sm">مدیریت واحد ها</p>
                </div>
            </a>

        </div>
    </div>

@endsection
