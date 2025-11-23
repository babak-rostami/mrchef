@extends('layouts.app')

@section('title', 'دسته بندی جدید')

@push('styles')
    @vite('resources/css/category/create.css')
@endpush

@section('content')

    <div class="mx-auto px-4">
        @include('partials.breadcrumb', [
            'breadcrumb_title' => 'دسته بندی جدید',
            'breadcrumb_parents' => [
                [
                    'url' => route('category.index'),
                    'title' => 'مدیریت دسته بندی ها',
                ],
            ],
        ])


        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">دسته بندی جدید</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="category-store-form" action="{{ route('category.store') }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            {{-- IMAGE --}}
                            @include('components.form.create.image', [
                                'bimage_title' => 'عکس اصلی دسته بندی',
                                'bimage_required' => true,
                                'bimage_accept' => 'image/*',
                                'bimage_msg' => 'برای نمایش بهتر سایز عکس 1*1 انتخاب کنید',
                                'bimage_name' => 'image',
                            ])
                        </div>

                        {{-- NAME --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'نام دسته بندی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: کیک',
                            'binput_msg' => 'حداکثر 40 کاراکتر',
                            'binput_name' => 'name',
                            'binput_role' => ['min-length' => 2, 'max-length' => 40],
                        ])

                        {{-- NAME EN --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'نام دسته بندی به انگلیسی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: cake',
                            'binput_msg' => 'حداکثر 40 کاراکتر',
                            'binput_name' => 'name_en',
                            'binput_role' => ['min-length' => 2, 'max-length' => 40],
                        ])

                        {{-- SLUG --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'اسلاگ',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: pasta-special',
                            'binput_msg' => 'فقط حروف انگلیسی، عدد و خط تیره مجاز است، فاصله مجاز نیست.',
                            'binput_name' => 'slug',
                            'binput_role' => ['slug' => true, 'min-length' => 2, 'max-length' => 40],
                        ])

                        {{-- PARENT --}}
                        @include('components.form.create.select', [
                            'bselect_title' => 'دسته بندی پدر',
                            'bselect_default_option' => 'بدون دسته بندی پدر',
                            'bselect_name' => 'parent_id',
                            'bselect_items' => $categories,
                            'bselect_items_name' => 'name',
                        ])

                        <div class="md:col-span-2 space-y-4">
                            {{-- DESCRIPTION --}}
                            @include('components.form.create.textarea', [
                                'btextarea_title' => 'توضیحات کوتاه',
                                'btextarea_required' => true,
                                'btextarea_place' => 'توضیح کوتاه درباره دسته بندی ...',
                                'btextarea_msg' => 'یک توضیح کوتاه برای دسته بندی بنویس',
                                'btextarea_name' => 'description',
                                'btextarea_role' => ['min-length' => 25],
                            ])

                            {{-- body CKEDITOR --}}
                            @include('components.form.create.ckeditor', [
                                'bckeditor_title' => 'متن سئو شده صفحه دسته بندی',
                                'bckeditor_place' => 'در این قسمت متن سئو شده برای صفحه دسته بندی رو بنویس',
                                'bckeditor_name' => 'body',
                            ])

                            {{-- SUBMIT --}}
                            @include('components.form.create.submit', [
                                'submit_title' => 'ثبت دسته بندی',
                            ])
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/category/create.js')
@endpush
