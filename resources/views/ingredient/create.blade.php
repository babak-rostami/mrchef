@extends('layouts.app')

@section('title', 'ماده اولیه جدید')

@push('styles')
    @vite('resources/css/ingredient/create.css')
@endpush

@section('content')

    <div class="mx-auto px-4">

        <x-partials.breadcrumb panel="admin" page="ماده اولیه جدید" :parents="[['url' => route('admin.ingredient.index'), 'title' => 'مدیریت مواد اولیه']]" />


        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ماده اولیه جدید</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="ingredient-store-form" action="{{ route('admin.ingredient.store') }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-1 md:col-span-2 gap-4">
                            {{-- IMAGE --}}
                            <x-form.create.image title="عکس ماده اولیه" name="image" id="image" :required="true"
                                accept="image/*" msg="برای نمایش بهتر سایز عکس 1*1 انتخاب کنید" />
                        </div>
                        {{-- NAME --}}
                        <x-form.create.input name="name" id="name" title="نام" placeholder="مثال: شکر"
                            :required="true" msg="حداکثر 55 کاراکتر" :roles="['max-len' => 55]" />

                        {{-- NAME EN --}}
                        <x-form.create.input name="name_en" id="name_en" title="نام انگلیسی" placeholder="مثال: sugar"
                            :required="true" msg="حداکثر 55 کاراکتر" :roles="['max-len' => 55]" />

                        {{-- SLUG --}}
                        <x-form.create.input name="slug" id="slug" title="اسلاگ" placeholder="مثال: olive-oil"
                            :required="true" msg="فقط حروف انگلیسی، عدد و خط تیره مجاز است، فاصله مجاز نیست."
                            :roles="['slug' => true, 'min-len' => 2, 'max-len' => 55]" />

                        {{-- SHOW IN SEARCH --}}
                        <x-form.create.select title="در فیلتر جستجو باشد؟" name="show_in_search" id="show_in_search"
                            :arrayItems="$show_select_options" />
                    </div>

                    {{-- SUBMIT --}}
                    <x-form.create.submit title="ثبت ماده اولیه" />

                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/ingredient/create.js')
@endpush
