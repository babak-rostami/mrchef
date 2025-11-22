@extends('layouts.app')

@section('title', 'مدیریت مواد اولیه')

@push('styles')
    @vite('resources/css/ingredient/index.css')
@endpush

@section('content')

    @include('partials.breadcrumb', ['breadcrumb_title' => 'مدیریت مواد اولیه'])

    <!-- Title + Create Button -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold">مدیریت مواد اولیه</h3>

        <a href="{{ route('ingredient.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
            <i class="fa fa-plus ml-1"></i>
            ماده اولیه جدید
        </a>

    </div>

    <!-- ingredient List -->
    <div class="bg-white rounded-2xl shadow p-6 mt-6">

        @if ($ingredients->count() == 0)

            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هیچ ماده اولیه ای یافت نشد</h5>

                <a href="{{ route('ingredient.create') }}"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                    <i class="fa fa-plus ml-1"></i>
                    ایجاد اولین ماده اولیه
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach ($ingredients as $ingredient)
                    <div
                        class="p-4 bg-white border border-gray-400 rounded-2xl
                    hover:shadow-md transition flex flex-col">

                        <!-- Image + Title -->
                        <div class="flex items-center mb-3">
                            <img src="{{ $ingredient->thumb_url }}" class="w-16 h-16 rounded-lg object-cover">
                            <div class="mr-3">
                                <h6 class="font-bold">{{ $ingredient->name }}</h6>
                                <span class="font-bold">{{ $ingredient->slug }}</span>
                                @if ($ingredient->show_in_search == 1)
                                    @include('component.helper.badge', [
                                        'title' => 'نمایش در فیلتر جستجو',
                                        'class' => 'success',
                                    ])
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-auto pt-3">

                            <a href="{{ route('ingredient.edit', $ingredient->slug) }}"
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
