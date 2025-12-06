@extends('layouts.app')

@section('title', 'ویرایش دسته بندی')

@push('styles')
    @vite('resources/css/category/edit.css')
@endpush

@section('content')

    <div class="mx-auto px-4">
        <x-partials.breadcrumb panel="admin" page="ویرایش دسته بندی" :parents="[['url' => route('admin.category.index'), 'title' => 'مدیریت دسته بندی ها']]" />

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش دسته‌بندی {{ $category->name }}</h3>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="category-update-form" action="{{ route('admin.category.update', $category->slug) }}" method="POST"
                    enctype="multipart/form-data" class="w-full md:w-3/4">
                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2 gap-4">
                            {{-- IMAGE --}}
                            <x-form.edit.image title="عکس دسته بندی" name="image" id="image" accept="image/*"
                                msg="برای نمایش بهتر سایز عکس 1*1 انتخاب کنید" :src="$category->image_url" />
                        </div>

                        {{-- NAME --}}
                        <x-form.edit.input name="name" id="name" title="نام" placeholder="مثال: سوخاری"
                            :required="true" msg="حداکثر 40 کاراکتر برای سئو بهتر" :roles="['max-len' => 40]" :value="$category->name" />

                        {{-- NAME EN --}}
                        <x-form.edit.input name="name_en" id="name_en" title="نام انگلیسی" placeholder="مثال: cake"
                            :required="true" msg="حداکثر 40 کاراکتر برای سئو بهتر" :roles="['max-len' => 40]" :value="$category->name_en" />

                        {{-- SLUG --}}
                        <x-form.edit.readonly id="slug" title="اسلاگ" msg="اسلاگ نباید تغییر کند" :value="$category->slug" />

                        {{-- PARENT CATEGORY --}}
                        <x-form.edit.select title="دسته بندی پدر" name="parent_id" id="parent_id" :items="$categories"
                            itemsName="name" :value="$category->parent_id" default="دسته بندی پدر ندارد" />

                        <div class="md:col-span-2 gap-4 mt-2">
                            {{-- DESCRIPTION --}}
                            <x-form.edit.textarea title="توضیحات" name="description" id="description"
                                placeholder="توضیح درباره دسته بندی ..." msg="یک توضیح برای دسته بندی بنویسید"
                                :required="true" :roles="['min-len' => 25]" :value="$category->description" />

                            {{-- body CKEDITOR --}}
                            <x-form.edit.ckeditor title="متن سئو شده" name="body" id="body"
                                placeholder="در این قسمت متن سئو شده برای صفحه دسته بندی رو بنویس" :value="$category->body" />

                            {{-- SUBMIT --}}
                            <x-form.edit.submit title="ثبت تغییرات" />

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
