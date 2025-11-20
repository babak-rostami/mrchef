@extends('layouts.app')

@section('title', 'رسپی جدید')

@push('styles')
    @vite('resources/css/recipe/create.css')
@endpush

@section('content')

    <div class="mx-auto px-4">
        @include('partials.breadcrumb', ['breadcrumb_title' => 'رسپی جدید'])

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">رسپی جدید</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="recipes-store-form" action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data"
                    class="w-full space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                        {{-- CATEGORY --}}
                        @include('component.form.select', [
                            'bselect_title' => 'دسته بندی',
                            'bselect_required' => true,
                            'bselect_default_option' => 'یک دسته‌بندی انتخاب کنید...',
                            'bselect_name' => 'category_id',
                            'bselect_items' => $categories,
                            'bselect_items_name' => 'name',
                        ])


                        {{-- IMAGE --}}
                        @include('component.form.image', [
                            'bimage_title' => 'عکس اصلی رسپی',
                            'bimage_required' => true,
                            'bimage_accept' => 'image/*',
                            'bimage_msg' => 'برای نمایش بهتر سایز عکس 1*1 انتخاب کنید',
                            'bimage_name' => 'image',
                        ])

                        {{-- TITLE --}}
                        @include('component.form.input', [
                            'binput_title' => 'عنوان',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: طرز تهیه پاستا مخصوص',
                            'binput_msg' => 'حداکثر 55 کاراکتر برای سئو بهتر.',
                            'binput_name' => 'title',
                            'binput_role' => ['min-length' => 15, 'max-length' => 55],
                        ])

                        {{-- SLUG --}}
                        @include('component.form.input', [
                            'binput_title' => 'اسلاگ',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: pasta-special',
                            'binput_msg' => 'فقط حروف انگلیسی، عدد و خط تیره مجاز است، فاصله مجاز نیست.',
                            'binput_name' => 'slug',
                            'binput_role' => ['slug' => true, 'min-length' => 15, 'max-length' => 55],
                        ])

                        {{-- STATUS --}}
                        @include('component.form.select', [
                            'bselect_title' => 'وضعیت',
                            'bselect_name' => 'status',
                            'bselect_array_items' => ['تایید نشده', 'تایید شده', 'در انتظار بررسی'],
                        ])

                        {{-- TIME PREPARE --}}
                        @include('component.form.number', [
                            'bnumber_title' => 'زمان آماده‌سازی',
                            'bnumber_place' => 'مثال: 20',
                            'bnumber_msg' => 'چند دقیقه طول میکشه وسایل آماده بشه',
                            'bnumber_name' => 'time_prepare',
                            'bnumber_role' => ['min-number' => 5, 'max-number' => 300],
                        ])

                        {{-- TIME COOK --}}
                        @include('component.form.number', [
                            'bnumber_title' => 'زمان پخت',
                            'bnumber_place' => 'مثال: 45',
                            'bnumber_msg' => 'چند دقیقه طول میکشه که غذا بپزه؟',
                            'bnumber_name' => 'time_cook',
                            'bnumber_role' => ['min-number' => 5, 'max-number' => 300],
                        ])

                        {{-- SERVINGS --}}
                        @include('component.form.number', [
                            'bnumber_title' => 'تعداد سرو',
                            'bnumber_place' => 'مثال: 4',
                            'bnumber_msg' => 'این دستور پخت برای چند نفر تهیه شده؟',
                            'bnumber_name' => 'servings',
                            'bnumber_role' => ['min-number' => 2, 'max-number' => 300],
                        ])

                    </div>

                    {{-- DESCRIPTION --}}
                    @include('component.form.textarea', [
                        'btextarea_title' => 'توضیحات کوتاه',
                        'btextarea_required' => true,
                        'btextarea_place' => 'توضیح کوتاه درباره رسپی ...',
                        'btextarea_msg' => 'یک توضیح کوتاه جذاب برای ابتدای مقاله بنویس',
                        'btextarea_name' => 'description',
                        'btextarea_role' => ['min-length' => 25],
                    ])

                    {{-- body CKEDITOR --}}
                    @include('component.form.ckeditor', [
                        'bckeditor_title' => 'طرز پخت',
                        'bckeditor_required' => true,
                        'bckeditor_place' => 'در این قسمت طرز پخت رو کامل‌ و با جزئیات بنویس',
                        'bckeditor_name' => 'body',
                    ])

                    {{-- SUBMIT --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="bg-blue-600 w-full text-white px-6 py-2 rounded-lg hover:bg-blue-700
                            transition cursor-pointer">
                            ثبت رسپی
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/recipe/create.js')
@endpush
