@extends('layouts.app')

@section('title', 'دسته بندی ها')

@push('styles')
    @vite('resources/css/category/index.css')
@endpush

@section('content')

    @include('partials.breadcrumb', ['breadcrumb_title' => 'مدیریت دسته بندی ها'])

    <!-- Title + Create Button -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold">مدیریت دسته‌بندی‌ها</h3>

        <button onclick="openModal('createCategoryModal')"
            class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition">
            <i class="fa fa-plus ml-1"></i> دسته‌بندی جدید
        </button>
    </div>

    <!-- Modal Create -->
    <div id="createCategoryModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6 animate-fadeIn">

            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-bold">ایجاد دسته‌بندی جدید</h5>
                <button class="text-gray-500 hover:text-black" onclick="closeModal('createCategoryModal')">✕</button>
            </div>

            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block mb-1 font-medium">نام دسته‌بندی</label>
                        <input type="text" name="name"
                            class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">نام انگلیسی دسته‌بندی</label>
                        <input type="text" name="name_en"
                            class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>

                    <div class="col-span-2">
                        <label class="block mb-1 font-medium">توضیحات</label>
                        <textarea name="description" rows="3"
                            class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring focus:ring-blue-300" required></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">دسته‌بندی پدر</label>
                        <select name="parent_id"
                            class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring focus:ring-blue-300">
                            <option value="">بدون دسته پدر</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">تصویر</label>
                        <input type="file" name="image"
                            class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                    </div>

                    <div class="col-span-2 text-left mt-2">
                        <button type="submit"
                            class="px-5 py-2 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition cursor-pointer w-full">
                            ثبت دسته‌بندی
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Categories List -->
    <div class="bg-white rounded-2xl shadow p-6 mt-6">

        @if ($categories->count() == 0)

            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هیچ دسته‌بندی‌ای یافت نشد</h5>

                <button onclick="openModal('createCategoryModal')"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition">
                    ایجاد اولین دسته‌بندی
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach ($categories as $category)
                    <div class="p-4 bg-white border rounded-2xl shadow-sm hover:shadow transition flex flex-col">

                        <!-- Image + Title -->
                        <div class="flex items-center mb-3">
                            <img src="{{ $category->thumb_url }}" class="w-14 h-14 rounded-lg object-cover">
                            <div class="mr-3">
                                <h6 class="font-bold">{{ $category->name }}</h6>
                                <span class="text-gray-500 text-sm">{{ $category->name_en }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-auto pt-3">

                            <a href="{{ route('category.edit', $category->slug) }}"
                                class="px-4 py-1.5 bg-yellow-500 text-white text-sm rounded-xl shadow hover:bg-yellow-600 transition">
                                ویرایش
                            </a>

                        </div>

                    </div>
                @endforeach

            </div>

        @endif

    </div>

@endsection

@push('scripts')
    @vite('resources/js/category/index.js')
@endpush
