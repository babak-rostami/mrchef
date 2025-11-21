@extends('layouts.app')

@section('title', 'مدیریت رسپی ها')

@push('styles')
    @vite('resources/css/recipe/index.css')
@endpush

@section('content')

    @include('partials.breadcrumb', ['breadcrumb_title' => 'مدیریت رسپی ها'])

    <!-- Title + Create Button -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold">مدیریت رسپی ها</h3>

        <a href="{{ route('recipes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
            <i class="fa fa-plus ml-1"></i>
            رسپی جدید
        </a>

    </div>

    <!-- recipes List -->
    <div class="bg-white rounded-2xl shadow p-6 mt-6">

        @if ($recipes->count() == 0)

            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هیچ رسپی یافت نشد</h5>

                <a href="{{ route('recipes.create') }}"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                    <i class="fa fa-plus ml-1"></i>
                    ایجاد اولین رسپی
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach ($recipes as $recipe)
                    <div
                        class="p-4 bg-white border border-gray-400 rounded-2xl
                    hover:shadow-md transition flex flex-col">

                        <!-- Image + Title -->
                        <div class="flex items-center mb-3">
                            <img src="{{ $recipe->thumb_url }}" class="w-16 h-16 rounded-lg object-cover">
                            <div class="mr-3">
                                <h6 class="font-bold">{{ $recipe->title }}</h6>
                            </div>
                        </div>

                        <div class="flex">
                            @if ($recipe->status == 0)
                                @include('component.helper.badge', [
                                    'title' => 'تایید نشده',
                                    'class' => 'danger',
                                ])
                            @elseif($recipe->status == 2)
                                @include('component.helper.badge', [
                                    'title' => 'تایید شده',
                                    'class' => 'success',
                                ])
                            @elseif($recipe->status == 1)
                                @include('component.helper.badge', [
                                    'title' => 'در انتظار',
                                    'class' => 'warning',
                                ])
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-auto pt-3">

                            <a href="{{ route('recipes.edit', $recipe->slug) }}"
                                class="px-4 py-1.5 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600">
                                ویرایش
                            </a>

                        </div>

                    </div>
                @endforeach

            </div>

        @endif

    </div>

@endsection
