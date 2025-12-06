@extends('layouts.app')

@section('title', 'ماده اولیه جدید')

@push('styles')
    @vite('resources/css/ingredient/edit.css')
@endpush

@section('content')

    <div class="mx-auto px-4">

        <x-partials.breadcrumb panel="admin" page="ویرایش ماده اولیه" :parents="[['url' => route('admin.ingredient.index'), 'title' => 'مدیریت مواد اولیه']]" />

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش ماده اولیه</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="ingredient-update-form" action="{{ route('admin.ingredient.update', $ingredient->slug) }}"
                    method="POST" enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        {{-- IMAGE --}}
                        <x-form.edit.image title="عکس ماده اولیه" name="image" id="image" accept="image/*"
                            msg="برای نمایش بهتر سایز عکس 1*1 انتخاب کنید" :src="$ingredient->image_url" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- NAME --}}
                        <x-form.edit.input name="name" id="name" title="نام" placeholder="مثال: شکر"
                            :required="true" msg="حداکثر 55 کاراکتر" :roles="['max-len' => 55]" :value="$ingredient->name" />

                        {{-- NAME EN --}}
                        <x-form.edit.input name="name_en" id="name_en" title="نام انگلیسی" placeholder="مثال: sugar"
                            :required="true" msg="حداکثر 55 کاراکتر" :roles="['max-len' => 55]" :value="$ingredient->name_en" />

                        {{-- SLUG --}}
                        <x-form.edit.readonly id="slug" title="اسلاگ" msg="اسلاگ نباید تغییر کند" :value="$ingredient->slug" />

                        {{-- SHOW IN SEARCH --}}
                        <x-form.edit.select title="در فیلتر جستجوی غذا باشد؟" name="show_in_search" id="show_in_search"
                            :arrayItems="$show_select_options" :value="$ingredient->show_in_search" />

                        {{-- calories_per_100g --}}
                        <x-form.edit.number name="calories_per_100g" id="calories_per_100g" title="کالری در 100 گرم"
                            placeholder="مثال: 387" msg="مقدار کالری در 100 گرم چقدر است؟" :roles="['min-number' => 0, 'max-number' => 100000]"
                            :value="$ingredient->calories_per_100g" />

                        {{-- fat_per_100g --}}
                        <x-form.edit.number name="fat_per_100g" id="fat_per_100g" title="چربی در 100 گرم"
                            placeholder="مثال: 387" msg="مقدار چربی در 100 گرم چقدر است؟" :roles="['min-number' => 0, 'max-number' => 100000]"
                            :value="$ingredient->fat_per_100g" />

                        {{-- carbs_per_100g --}}
                        <x-form.edit.number name="carbs_per_100g" id="carbs_per_100g" title="کربوهیدرات در 100 گرم"
                            placeholder="مثال: 387" msg="مقدار کربوهیدرات در 100 گرم چقدر است؟" :roles="['min-number' => 0, 'max-number' => 100000]"
                            :value="$ingredient->carbs_per_100g" />

                        {{-- protein_per_100g --}}
                        <x-form.edit.number name="protein_per_100g" id="protein_per_100g" title="پروتئین در 100 گرم"
                            placeholder="مثال: 387" msg="مقدار پروتئین در 100 گرم چقدر است؟" :roles="['min-number' => 0, 'max-number' => 100000]"
                            :value="$ingredient->protein_per_100g" />

                    </div>

                    {{-- SUBMIT --}}
                    <x-form.edit.submit title="ثبت تغییرات ماده اولیه" />

                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/ingredient/edit.js')
@endpush
