@extends('layouts.app')

@section('title', 'ویرایش رسپی')

@push('styles')
    @vite('resources/css/recipe/edit.css')
@endpush

@section('content')

    <div class="mx-auto px-4">
        @include('partials.breadcrumb', [
            'breadcrumb_title' => 'ویرایش رسپی',
            'breadcrumb_parents' => [
                [
                    'url' => route('recipes.index'),
                    'title' => 'مدیریت رسپی ها',
                ],
            ],
        ])


        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش رسپی</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="recipes-update-form" action="{{ route('recipes.update', $recipe->slug) }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        {{-- IMAGE --}}
                        @include('components.form.edit.image', [
                            'bimage_title' => 'عکس اصلی رسپی',
                            'bimage_accept' => 'image/*',
                            'bimage_msg' => 'برای نمایش بهتر سایز عکس 1*1 انتخاب کنید',
                            'bimage_name' => 'image',
                            'bimage_src' => $recipe->image_url,
                        ])
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- CATEGORY --}}
                        @include('components.form.edit.select', [
                            'bselect_title' => 'دسته بندی',
                            'bselect_required' => true,
                            'bselect_name' => 'category_id',
                            'bselect_items' => $categories,
                            'bselect_items_name' => 'name',
                            'bselect_value' => $recipe->category_id,
                        ])

                        {{-- TITLE --}}
                        @include('components.form.edit.input', [
                            'binput_title' => 'عنوان',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: طرز تهیه پاستا مخصوص',
                            'binput_msg' => 'حداکثر 55 کاراکتر برای سئو بهتر.',
                            'binput_name' => 'title',
                            'binput_role' => ['min-length' => 15, 'max-length' => 55],
                            'binput_value' => $recipe->title,
                        ])

                        {{-- SLUG --}}
                        @include('components.form.edit.readonly', [
                            'binput_title' => 'اسلاگ',
                            'binput_name' => 'slug',
                            'binput_msg' => 'اسلاگ نباید تغییر کند',
                            'binput_value' => $recipe->slug,
                        ])

                        {{-- STATUS --}}
                        @include('components.form.edit.select', [
                            'bselect_title' => 'وضعیت',
                            'bselect_name' => 'status',
                            'bselect_array_items' => ['تایید نشده', 'تایید شده', 'در انتظار بررسی'],
                            'bselect_value' => $recipe->status,
                        ])

                        {{-- TIME PREPARE --}}
                        @include('components.form.edit.number', [
                            'bnumber_title' => 'زمان آماده‌سازی',
                            'bnumber_place' => 'مثال: 20',
                            'bnumber_msg' => 'چند دقیقه طول میکشه وسایل آماده بشه',
                            'bnumber_name' => 'time_prepare',
                            'bnumber_role' => ['min-number' => 5, 'max-number' => 1000],
                            'bnumber_value' => $recipe->time_prepare,
                        ])

                        {{-- TIME COOK --}}
                        @include('components.form.edit.number', [
                            'bnumber_title' => 'زمان پخت',
                            'bnumber_place' => 'مثال: 45',
                            'bnumber_msg' => 'چند دقیقه طول میکشه که غذا بپزه؟',
                            'bnumber_name' => 'time_cook',
                            'bnumber_role' => ['min-number' => 5, 'max-number' => 1000],
                            'bnumber_value' => $recipe->time_cook,
                        ])

                        {{-- SERVINGS --}}
                        @include('components.form.edit.number', [
                            'bnumber_title' => 'تعداد سرو',
                            'bnumber_place' => 'مثال: 4',
                            'bnumber_msg' => 'این دستور پخت برای چند نفر تهیه شده؟',
                            'bnumber_name' => 'servings',
                            'bnumber_role' => ['min-number' => 2, 'max-number' => 500],
                            'bnumber_value' => $recipe->servings,
                        ])

                    </div>

                    {{-- DESCRIPTION --}}
                    @include('components.form.edit.textarea', [
                        'btextarea_title' => 'توضیحات کوتاه',
                        'btextarea_required' => true,
                        'btextarea_place' => 'توضیح کوتاه درباره رسپی ...',
                        'btextarea_msg' => 'یک توضیح کوتاه جذاب برای ابتدای مقاله بنویس',
                        'btextarea_name' => 'description',
                        'btextarea_role' => ['min-length' => 25],
                        'btextarea_value' => $recipe->description,
                    ])

                    {{-- body CKEDITOR --}}
                    @include('components.form.edit.ckeditor', [
                        'bckeditor_title' => 'طرز پخت',
                        'bckeditor_required' => true,
                        'bckeditor_place' => 'در این قسمت طرز پخت رو کامل‌ و با جزئیات بنویس',
                        'bckeditor_name' => 'body',
                        'bckeditor_value' => $recipe->body,
                    ])

                    {{-- SUBMIT --}}
                    @include('components.form.edit.submit', [
                        'submit_title' => 'ثبت تغییرات رسپی',
                    ])
                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/recipe/edit.js')
@endpush
