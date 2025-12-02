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
                    'url' => route('admin.category.index'),
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
                <form id="category-store-form" action="{{ route('admin.category.store') }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            {{-- IMAGE --}}
                            <x-form.create.image title="عکس دسته بندی" name="image" id="image" :required="true"
                                accept="image/*" msg="برای نمایش بهتر سایز عکس 1*1 انتخاب کنید" />
                        </div>

                        {{-- NAME --}}
                        <x-form.create.input name="name" id="name" title="نام دسته بندی" placeholder="مثال: کیک"
                            :required="true" msg="حداکثر 40 کاراکتر" :roles="['min-len' => 2, 'max-len' => 40]" />

                        {{-- NAME EN --}}
                        <x-form.create.input name="name_en" id="name_en" title="نام انگلیسی دسته بندی"
                            placeholder="مثال: cake" :required="true" msg="حداکثر 40 کاراکتر" :roles="['min-len' => 2, 'max-len' => 40]" />

                        {{-- SLUG --}}
                        <x-form.create.input name="slug" id="slug" title="اسلاگ" placeholder="مثال: olive-oil"
                            :required="true" msg="فقط حروف انگلیسی، عدد و خط تیره مجاز است، فاصله مجاز نیست."
                            :roles="['slug' => true, 'min-len' => 2, 'max-len' => 40]" />

                        {{-- PARENT --}}
                        <x-form.create.select title="دسته بندی پدر" name="parent_id" id="parent_id"
                            default="بدون دسته بندی پدر" :items="$categories" itemsName="name" />

                        <div class="md:col-span-2 space-y-4">
                            {{-- DESCRIPTION --}}
                            <x-form.create.textarea title="توضیحات کوتاه" name="description" id="description"
                                placeholder="توضیح کوتاه درباره دسته بندی ..." msg="یک توضیح کوتاه برای دسته بندی بنویس"
                                :required="true" :roles="['min-len' => 25, 'max-len' => 160]" />

                            {{-- body CKEDITOR --}}
                            <x-form.create.ckeditor title="متن سئو شده صفحه دسته بندی" name="body" id="body"
                                placeholder="در این قسمت متن سئو شده برای صفحه دسته بندی بنویس"
                                msg="این متن برای سئوی صفحه نمایش داده می‌شود" :required="true" />

                            {{-- SUBMIT --}}
                            <x-form.create.submit title="ثبت دسته بندی" />
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
