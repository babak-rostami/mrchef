@extends('layouts.app')

@section('title', 'ویرایش دسته بندی')

@push('styles')
    @vite('resources/css/category/edit.css')
@endpush

@section('content')

    <div class="mx-auto px-4">
        @include('partials.breadcrumb', ['breadcrumb_title' => 'ویرایش دسته بندی'])

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش دسته‌بندی {{ $category->name }}</h3>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form action="{{ route('category.update', $category->slug) }}" method="POST" enctype="multipart/form-data"
                    class="w-full md:w-3/4">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Image -->
                        <div class="col-span-1 md:col-span-2 text-center">
                            <img src="{{ $category->thumb_url }}" alt="{{ $category->name }}"
                                class="w-24 h-24 object-cover rounded-lg mx-auto">
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block mb-2 font-medium">نام دسته‌بندی</label>
                            <input type="text" name="name" value="{{ $category->name }}"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-300" required>
                        </div>

                        <!-- English Name -->
                        <div>
                            <label class="block mb-2 font-medium">نام انگلیسی دسته‌بندی</label>
                            <input type="text" name="name_en" value="{{ $category->name_en }}"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-300" required>
                        </div>

                        <!-- Description -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block mb-2 font-medium">توضیحات</label>
                            <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-300"
                                required>{{ $category->description }}</textarea>
                        </div>

                        <!-- Parent -->
                        <div>
                            <label class="block mb-2 font-medium">دسته‌بندی پدر</label>
                            <select name="parent_id"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-300">
                                <option value="">بدون دسته پدر</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block mb-2 font-medium">تصویر</label>
                            <input type="file" name="image"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-indigo-300">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-span-1 md:col-span-2 mt-4">
                            <button type="submit"
                                class="w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition cursor-pointer">
                                ثبت تغییرات
                            </button>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection
