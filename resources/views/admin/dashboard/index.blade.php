@extends('layouts.app')

@section('title', 'داشبورد')

@push('styles')
    @vite(['resources/css/user/dashboard.css'])
@endpush


@section('content')

    <div class="md:mx-8 lg:mx-44 bg-gray-50 px-4 py-8 rounded-2xl">
        <h1 class="text-center mb-6 font-bold text-2xl">داشبورد مدیریت</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-center">

            <!-- دسته بندی‌ها -->
            @include('admin.dashboard.page-item', [
                'route' => route('admin.category.index'),
                'icon' => config('images.ftp_path') . '/files/icon/category-48.png',
                'title' => 'دسته بندی',
                'desc' => 'مدیریت دسته بندی',
            ])

            <!-- رسپی ها -->
            @include('admin.dashboard.page-item', [
                'route' => route('admin.recipes.index'),
                'icon' => config('images.ftp_path') . '/files/icon/recipe-48.png',
                'title' => 'رسپی ها',
                'desc' => 'مدیریت رسپی ها',
            ])

            <!-- مواد اولیه -->
            @include('admin.dashboard.page-item', [
                'route' => route('admin.ingredient.index'),
                'icon' => config('images.ftp_path') . '/files/icon/ingredient-48.png',
                'title' => 'مواد اولیه',
                'desc' => 'مدیریت مواد اولیه',
            ])

            <!-- واحد ها -->
            @include('admin.dashboard.page-item', [
                'route' => route('admin.unit.index'),
                'icon' => config('images.ftp_path') . '/files/icon/units-48.png',
                'title' => 'واحد های اندازه گیری',
                'desc' => 'مدیریت واحد های اندازه گیری',
            ])

            <!-- پیام‌های تماس با ما -->
            @include('admin.dashboard.page-item', [
                'route' => route('admin.messages.index'),
                'icon_class' => 'fa fa-envelope',
                'title' => 'پیام‌های تماس',
                'desc' => 'مشاهده پیام‌های ارسالی کاربران',
                'badge' => $unreadMessagesCount > 0 ? $unreadMessagesCount : null,
            ])

            <!-- نظرات -->
            @include('admin.dashboard.page-item', [
                'route' => route('admin.comments.index'),
                'icon_class' => 'fa fa-comments',
                'title' => 'نظرات',
                'desc' => 'ویرایش و حذف نظرات کاربران',
            ])

        </div>
    </div>

@endsection