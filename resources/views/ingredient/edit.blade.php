@extends('layouts.app')

@section('title', 'ماده اولیه جدید')

@push('styles')
    @vite('resources/css/ingredient/edit.css')
@endpush

@section('content')

    <div class="mx-auto px-4">
        @include('partials.breadcrumb', [
            'breadcrumb_title' => 'ماده اولیه جدید',
            'breadcrumb_parents' => [
                [
                    'url' => route('ingredient.index'),
                    'title' => 'مدیریت مواد اولیه',
                ],
            ],
        ])


        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش ماده اولیه</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="ingredient-update-form" action="{{ route('ingredient.update', $ingredient->slug) }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        {{-- IMAGE --}}
                        @include('component.form.edit.image', [
                            'bimage_title' => 'عکس ماده اولیه',
                            'bimage_accept' => 'image/*',
                            'bimage_msg' => 'برای نمایش بهتر سایز عکس 1*1 انتخاب کنید',
                            'bimage_name' => 'image',
                            'bimage_src' => $ingredient->image_url,
                        ])
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- NAME --}}
                        @include('component.form.edit.input', [
                            'binput_title' => 'نام',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: شکر',
                            'binput_msg' => 'حداکثر 55 کاراکتر',
                            'binput_name' => 'name',
                            'binput_role' => ['max-length' => 55],
                            'binput_value' => $ingredient->name,
                        ])

                        {{-- NAME EN --}}
                        @include('component.form.edit.input', [
                            'binput_title' => 'نام انگلیسی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: sugar',
                            'binput_msg' => 'حداکثر 55 کاراکتر',
                            'binput_name' => 'name_en',
                            'binput_role' => ['max-length' => 55],
                            'binput_value' => $ingredient->name_en,
                        ])

                        {{-- SLUG --}}
                        @include('component.form.edit.readonly', [
                            'binput_title' => 'اسلاگ',
                            'binput_name' => 'slug',
                            'binput_msg' => 'اسلاگ نباید تغییر کند',
                            'binput_value' => $ingredient->slug,
                        ])

                        {{-- SHOW IN SEARCH --}}
                        @include('component.form.edit.select', [
                            'bselect_title' => 'در فیلتر جستجوی غذا باشد؟',
                            'bselect_name' => 'show_in_search',
                            'bselect_array_items' => ['خیر', 'بله'],
                            'bselect_value' => $ingredient->show_in_search,
                        ])

                    </div>

                    {{-- SUBMIT --}}
                    @include('component.form.edit.submit', [
                        'submit_title' => 'ثبت تغییرات ماده اولیه',
                    ])
                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/ingredient/edit.js')
@endpush
