@extends('layouts.app')

@section('title', 'دسته بندی ها')

@section('styles')
    @vite(['resources/css/category/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="مدیریت دسته بندی ها" />
    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">مدیریت دسته‌بندی‌ها</h3>

            <a class="px-4 py-1.5 cursor-pointer bg-blue-500 mr-2 text-white rounded-xl shadow hover:bg-blue-600"
                href="{{ route('admin.category.create') }}">دسته بندی جدید</a>
        </div>

        <!-- Categories List -->
        <div class="mt-6">

            @if ($categories->count() == 0)
                <div class="flex flex-col items-center py-10 mb-32">
                    <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                    <h5 class="text-gray-500">هنوز دسته بندی ایجاد نکردی</h5>

                    <a class="px-4 py-1.5 cursor-pointer bg-blue-500 mr-2 mt-4 text-white rounded-xl shadow hover:bg-blue-600"
                        href="{{ route('admin.category.create') }}">دسته بندی جدید</a>
                </div>
            @else
                <x-partials.table.index id="categories" :columns="[
                    ['key' => 'id', 'label' => 'id', 'sortable' => true],
                    ['key' => 'thumb', 'label' => 'تصویر', 'view' => 'category.part.table.thumb'],
                    ['key' => 'name', 'label' => 'نام', 'sortable' => true, 'searchable' => true],
                    ['key' => 'name_en', 'label' => 'نام انگلیسی', 'searchable' => true],
                    ['key' => 'parent', 'label' => 'دسته پدر', 'view' => 'category.part.table.parent'],
                    ['key' => 'actions', 'label' => '#', 'view' => 'category.part.table.actions'],
                ]" :rows="$categories" />
            @endif

        </div>
    </div>

@endsection

@section('scripts')
    @vite(['resources/js/category/index.js'])
@endsection
