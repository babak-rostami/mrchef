@extends('layouts.app')

@section('title', 'رسپی جدید')

@section('styles')
    @vite(['resources/css/recipe/create.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="رسپی جدید" :parents="[['url' => route('admin.recipes.index'), 'title' => 'مدیریت رسپی ها']]" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">رسپی جدید</h3>
        </div>

        <div class="flex justify-center">
            <form id="recipes-store-form" action="{{ route('admin.recipes.store') }}" method="POST"
                enctype="multipart/form-data" class="w-full space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-4">
                    {{-- IMAGE --}}
                    <x-form.create.image title="عکس رسپی" name="image" id="image" :required="true" accept="image/*"
                        msg="برای نمایش بهتر سایز عکس 1*1 انتخاب کنید" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- CATEGORY --}}
                    <x-form.create.select title="دسته بندی" name="category_id" id="category_id" :required="true"
                        default="یک دسته‌بندی انتخاب کنید..." :items="$categories" itemsName="name" />

                    {{-- TITLE --}}
                    <x-form.create.input name="title" id="title" title="عنوان"
                        placeholder="مثال: طرز تهیه پاستا مخصوص" :required="true" msg="حداکثر 55 کاراکتر برای سئو بهتر"
                        :roles="['min-len' => 15, 'max-len' => 55]" />

                    {{-- SLUG --}}
                    <x-form.create.input name="slug" id="slug" title="اسلاگ" placeholder="مثال: olive-oil"
                        :required="true" msg="فقط حروف انگلیسی، عدد و خط تیره مجاز است، فاصله مجاز نیست."
                        :roles="['slug' => true, 'min-len' => 15, 'max-len' => 55]" />

                    {{-- STATUS --}}
                    <x-form.create.select title="وضعیت" name="status" id="status" :arrayItems="$status_select_options" />

                    {{-- TIME PREPARE --}}
                    <x-form.create.number name="time_prepare" id="time_prepare" title="زمان آماده سازی"
                        placeholder="مثال: 20" msg="چند دقیقه طول میکشه وسایل آماده بشه؟" :roles="['min-number' => 5, 'max-number' => 1000]" />

                    {{-- TIME COOK --}}
                    <x-form.create.number name="time_cook" id="time_cook" title="زمان پخت" placeholder="مثال: 45"
                        msg="چند دقیقه طول میکشه که غذا بپزه؟" :roles="['min-number' => 5, 'max-number' => 1000]" />

                    {{-- SERVINGS --}}
                    <x-form.create.number name="servings" id="servings" title="تعداد سرو" placeholder="مثال: 4"
                        msg="این دستور پخت برای چند نفر تهیه شده؟" :roles="['min-number' => 2, 'max-number' => 500]" />

                </div>

                {{-- DESCRIPTION --}}
                <x-form.create.textarea title="توضیحات کوتاه" name="description" id="description"
                    placeholder="توضیح کوتاه درباره رسپی ..." msg="یک توضیح کوتاه جذاب برای ابتدای مقاله بنویس"
                    :required="true" :roles="['min-len' => 25]" />

                {{-- body CKEDITOR --}}
                <x-form.create.ckeditor title="طرز پخت" name="body" id="body"
                    placeholder="طرز پخت رو کامل‌ و با جزئیات بنویس" msg="در این قسمت طرز پخت رو کامل‌ و با جزئیات بنویس"
                    :required="true" />

                {{-- SUBMIT --}}
                <x-form.create.submit title="ثبت رسپی" />

            </form>
        </div>

    </div>

@endsection

@section('scripts')
    @vite(['resources/js/recipe/create.js'])
@endsection
