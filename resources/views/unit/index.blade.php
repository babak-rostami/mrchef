@extends('layouts.app')

@section('title', 'واحد های اندازه گیری')

@section('styles')
    @vite(['resources/css/unit/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="واحد های اندازه گیری" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-12 mt-8">

        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">واحد های اندازه گیری</h3>

            <a href="{{ route('admin.unit.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                <i class="fa fa-plus ml-1"></i>
                واحد اندازه گیری جدید
            </a>

        </div>

        <!-- unit List -->
        @if ($units->count() == 0)
            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هیچ واحد اندازه گیری ای یافت نشد</h5>

                <a href="{{ route('admin.unit.create') }}"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                    <i class="fa fa-plus ml-1"></i>
                    ایجاد اولین واحد اندازه گیری
                </a>
            </div>
        @else
            <x-partials.table.index id="units" :columns="[
                ['key' => 'id', 'label' => 'id', 'sortable' => true],
                ['key' => 'name', 'label' => 'نام', 'sortable' => true, 'searchable' => true],
                ['key' => 'name_en', 'label' => 'نام انگلیسی', 'sortable' => true, 'searchable' => true],
                ['key' => 'label', 'label' => 'اختصار', 'sortable' => true, 'searchable' => true],
                ['key' => 'actions', 'label' => '#', 'view' => 'unit.part.table.actions'],
            ]" :rows="$units" />
        @endif

    </div>

@endsection

@section('scripts')
    @vite(['resources/js/unit/index.js'])
@endsection
