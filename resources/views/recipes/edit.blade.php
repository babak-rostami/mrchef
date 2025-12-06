@extends('layouts.app')

@section('title', 'ویرایش رسپی')

@push('styles')
    @vite('resources/css/recipe/edit.css')
@endpush

@section('content')

    <x-partials.breadcrumb panel="admin" page="ویرایش رسپی" :parents="[['url' => route('admin.recipes.index'), 'title' => 'مدیریت رسپی ها']]" />

    <div class="md:mx-8 lg:mx-44">

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش رسپی</h3>
        </div>


        <div class="flex justify-center">
            <form id="recipes-update-form" action="{{ route('admin.recipes.update', $recipe->slug) }}" method="POST"
                enctype="multipart/form-data" class="w-full space-y-6">
                @csrf

                @method('PUT')

                <div class="grid grid-cols-1 gap-4">
                    {{-- IMAGE --}}
                    <x-form.edit.image title="عکس رسپی" name="image" id="image" accept="image/*"
                        msg="برای نمایش بهتر سایز عکس 1*1 انتخاب کنید" :src="$recipe->image_url" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- CATEGORY --}}
                    <x-form.edit.select title="دسته بندی" name="category_id" id="category_id" :items="$categories"
                        itemsName="name" :value="$recipe->category_id" />


                    {{-- TITLE --}}
                    <x-form.edit.input name="title" id="title" title="عنوان" placeholder="مثال: طرز تهیه پاستا مخصوص"
                        :required="true" msg="حداکثر 55 کاراکتر برای سئو بهتر" :roles="['min-len' => 15, 'max-len' => 55]" :value="$recipe->title" />


                    {{-- SLUG --}}
                    <x-form.edit.readonly id="slug" title="اسلاگ" msg="اسلاگ نباید تغییر کند" :value="$recipe->slug" />

                    {{-- STATUS --}}
                    <x-form.edit.select title="وضعیت" name="status" id="status" :arrayItems="$status_select_options" :value="$recipe->status" />

                    {{-- TIME PREPARE --}}
                    <x-form.edit.number name="time_prepare" id="time_prepare" title="زمان آماده سازی" placeholder="مثال: 20"
                        msg="چند دقیقه طول میکشه وسایل آماده بشه؟" :roles="['min-number' => 5, 'max-number' => 1000]" :value="$recipe->time_prepare" />

                    {{-- TIME COOK --}}
                    <x-form.edit.number name="time_cook" id="time_cook" title="زمان پخت" placeholder="مثال: 45"
                        msg="چند دقیقه طول میکشه که غذا بپزه؟" :roles="['min-number' => 5, 'max-number' => 1000]" :value="$recipe->time_cook" />


                    {{-- SERVINGS --}}
                    <x-form.edit.number name="servings" id="servings" title="تعداد سرو" placeholder="مثال: 4"
                        msg="این دستور پخت برای چند نفر تهیه شده؟" :roles="['min-number' => 2, 'max-number' => 500]" :value="$recipe->servings" />

                </div>

                {{-- DESCRIPTION --}}
                <x-form.edit.textarea title="توضیحات کوتاه" name="description" id="description"
                    placeholder="توضیح کوتاه درباره رسپی ..." msg="یک توضیح کوتاه جذاب برای ابتدای مقاله بنویس"
                    :required="true" :roles="['min-len' => 25]" :value="$recipe->description" />

                {{-- body CKEDITOR --}}
                <x-form.edit.ckeditor title="طرز پخت" name="body" id="body"
                    placeholder="طرز پخت رو کامل‌ و با جزئیات بنویس" msg="در این قسمت طرز پخت رو کامل‌ و با جزئیات بنویس"
                    :required="true" :value="$recipe->body" />

                {{-- SUBMIT --}}
                <x-form.edit.submit title="ثبت تغییرات رسپی" />

            </form>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/recipe/edit.js')
@endpush
