@extends('layouts.app')

@section('title', 'ماده اولیه جدید')

@push('styles')
    @vite('resources/css/ingredient/create.css')
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
            <h3 class="text-xl font-bold">ماده اولیه جدید</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="ingredient-store-form" action="{{ route('ingredient.store') }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-4">

                        {{-- IMAGE --}}
                        @include('components.form.create.image', [
                            'bimage_title' => 'عکس ماده اولیه',
                            'bimage_required' => true,
                            'bimage_accept' => 'image/*',
                            'bimage_msg' => 'برای نمایش بهتر سایز عکس 1*1 انتخاب کنید',
                            'bimage_name' => 'image',
                        ])
                        
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- NAME --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'نام',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: شکر',
                            'binput_msg' => 'حداکثر 55 کاراکتر',
                            'binput_name' => 'name',
                            'binput_role' => ['max-length' => 55],
                        ])

                        {{-- NAME EN --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'نام انگلیسی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: sugar',
                            'binput_msg' => 'حداکثر 55 کاراکتر',
                            'binput_name' => 'name_en',
                            'binput_role' => ['max-length' => 55],
                        ])

                        {{-- SLUG --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'اسلاگ',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: olive-oil',
                            'binput_msg' => 'فقط حروف انگلیسی، عدد و خط تیره مجاز است، فاصله مجاز نیست.',
                            'binput_name' => 'slug',
                            'binput_role' => ['slug' => true, 'min-length' => 2, 'max-length' => 55],
                        ])

                        {{-- SHOW IN SEARCH --}}
                        @include('components.form.create.select', [
                            'bselect_title' => 'در فیلتر جستجوی غذا باشد؟',
                            'bselect_name' => 'show_in_search',
                            'bselect_array_items' => ['خیر', 'بله'],
                        ])

                    </div>

                    {{-- SUBMIT --}}
                    @include('components.form.create.submit', [
                        'submit_title' => 'ثبت ماده اولیه',
                    ])

                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/ingredient/create.js')
@endpush
