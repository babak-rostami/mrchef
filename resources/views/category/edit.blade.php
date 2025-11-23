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
                <form id="category-update-form" action="{{ route('category.update', $category->slug) }}" method="POST"
                    enctype="multipart/form-data" class="w-full md:w-3/4">
                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- IMAGE --}}
                        <div class="md:col-span-2 gap-4">
                            @include('components.form.edit.image', [
                                'bimage_title' => 'عکس دسته بندی',
                                'bimage_accept' => 'image/*',
                                'bimage_msg' => 'برای نمایش بهتر سایز عکس 1*1 انتخاب کنید',
                                'bimage_name' => 'image',
                                'bimage_src' => $category->image_url,
                            ])
                        </div>

                        {{-- NAME --}}
                        @include('components.form.edit.input', [
                            'binput_title' => 'نام',
                            'bf_is_required' => true,
                            'binput_place' => 'مثلا: سوخاری',
                            'binput_msg' => 'حداکثر 40 کاراکتر',
                            'binput_name' => 'name',
                            'binput_role' => ['max-length' => 40],
                            'binput_value' => $category->name,
                        ])

                        {{-- NAME EN --}}
                        @include('components.form.edit.input', [
                            'binput_title' => 'نام انگلیسی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: cake',
                            'binput_msg' => 'حداکثر 40 کاراکتر',
                            'binput_name' => 'name_en',
                            'binput_role' => ['max-length' => 40],
                            'binput_value' => $category->name_en,
                        ])

                        {{-- SLUG --}}
                        @include('components.form.edit.readonly', [
                            'binput_title' => 'اسلاگ',
                            'binput_name' => 'slug',
                            'binput_msg' => 'اسلاگ نباید تغییر کند',
                            'binput_value' => $category->slug,
                        ])

                        {{-- PARENT CATEGORY --}}
                        @include('components.form.edit.select', [
                            'bselect_title' => 'دسته بندی پدر',
                            'bselect_name' => 'parent_id',
                            'bselect_default_option' => 'بدون دسته بندی پدر',
                            'bselect_items' => $categories,
                            'bselect_items_name' => 'name',
                            'bselect_value' => $category->parent_id,
                        ])

                        <div class="md:col-span-2 gap-4 mt-2">
                            {{-- DESCRIPTION --}}
                            @include('components.form.edit.textarea', [
                                'btextarea_title' => 'توضیحات',
                                'btextarea_required' => true,
                                'btextarea_place' => 'توضیح درباره دسته بندی ...',
                                'btextarea_msg' => 'یک توضیح برای دسته بندی بنویسید',
                                'btextarea_name' => 'description',
                                'btextarea_role' => ['min-length' => 25],
                                'btextarea_value' => $category->description,
                            ])

                            {{-- body CKEDITOR --}}
                            @include('components.form.edit.ckeditor', [
                                'bckeditor_title' => 'متن سئو شده صفحه دسته بندی',
                                'bckeditor_place' => 'در این قسمت متن سئو شده برای صفحه دسته بندی رو بنویس',
                                'bckeditor_name' => 'body',
                                'bckeditor_value' => $category->body,
                            ])


                            {{-- SUBMIT --}}
                            @include('components.form.edit.submit', [
                                'submit_title' => 'ثبت تغییرات',
                            ])
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection


@push('scripts')
    @vite('resources/js/category/edit.js')
@endpush
