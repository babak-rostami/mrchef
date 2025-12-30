@extends('layouts.app')

@section('title', 'مدیریت رسپی ها')

@section('styles')
    @vite(['resources/css/recipe/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="مدیریت رسپی ها" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">مدیریت رسپی ها</h3>

            <a href="{{ route('admin.recipes.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                <i class="fa fa-plus ml-1"></i>
                رسپی جدید
            </a>

        </div>

        @if ($recipes->count() == 0)
            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هنوز رسپی ایجاد نکردین</h5>

                <a href="{{ route('admin.recipes.create') }}"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                    <i class="fa fa-plus ml-1"></i>
                    ایجاد اولین رسپی
                </a>
            </div>
        @else
            <x-partials.table.index id="recipes" :columns="[
                ['key' => 'id', 'label' => 'id', 'sortable' => true],
                ['key' => 'thumb', 'label' => 'تصویر', 'view' => 'recipes.part.table.thumb'],
                ['key' => 'title', 'label' => 'عنوان', 'sortable' => true, 'searchable' => true],
                ['key' => 'status', 'label' => 'وضعیت', 'view' => 'recipes.part.table.status'],
                ['key' => 'actions', 'label' => '#', 'view' => 'recipes.part.table.actions'],
            ]" :rows="$recipes" />
        @endif
    </div>

@endsection

@section('scripts')
    @vite(['resources/js/recipe/index.js'])
@endsection
