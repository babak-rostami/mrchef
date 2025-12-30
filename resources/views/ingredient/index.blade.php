@extends('layouts.app')

@section('title', 'مدیریت مواد اولیه')

@section('styles')
    @vite(['resources/css/ingredient/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="مدیریت مواد اولیه" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">مدیریت مواد اولیه</h3>

            <a href="{{ route('admin.ingredient.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                <i class="fa fa-plus ml-1"></i>
                ماده اولیه جدید
            </a>

        </div>

        <!-- ingredient List -->
        <div class="mt-6">

            @if ($ingredients->count() == 0)
                <div class="flex flex-col items-center py-10 mb-32">
                    <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                    <h5 class="text-gray-500">هنوز ماده اولیه ایجاد نکرده اید</h5>

                    <a href="{{ route('admin.ingredient.create') }}"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                        <i class="fa fa-plus ml-1"></i>
                        ایجاد اولین ماده اولیه
                    </a>
                </div>
            @else
                <x-partials.table.index id="ingredients" :columns="[
                    ['key' => 'id', 'label' => 'id', 'sortable' => true],
                    ['key' => 'thumb', 'label' => 'تصویر', 'view' => 'ingredient.part.table.thumb'],
                    ['key' => 'name', 'label' => 'عنوان', 'sortable' => true, 'searchable' => true],
                    ['key' => 'slug', 'label' => 'اسلاگ', 'searchable' => true],
                    ['key' => 'show_in_search', 'label' => 'قابلیت جستجو', 'view' => 'ingredient.part.table.show_in_search'],
                    ['key' => 'actions', 'label' => '#', 'view' => 'ingredient.part.table.actions'],
                ]" :rows="$ingredients" />
            @endif

        </div>
    </div>

@endsection

@section('scripts')
    @vite(['resources/js/ingredient/index.js'])
@endsection
