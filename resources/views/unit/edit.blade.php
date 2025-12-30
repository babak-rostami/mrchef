@extends('layouts.app')

@section('title', 'واحد اندازه گیری جدید')

@section('styles')
    @vite(['resources/css/unit/edit.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="ویرایش واحد اندازه گیری" :parents="[['url' => route('admin.unit.index'), 'title' => 'واحد های اندازه گیری']]" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش واحد اندازه گیری</h3>
        </div>

        <div class="flex justify-center">
            <form id="unit-update-form" action="{{ route('admin.unit.update', $unit->id) }}" method="POST"
                enctype="multipart/form-data" class="w-full space-y-6">
                @csrf

                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- NAME --}}
                    <x-form.edit.input name="name" id="name" title="نام" placeholder="مثال: گرم"
                        :required="true" msg="حداکثر 20 کاراکتر" :roles="['max-len' => 20]" :value="$unit->name" />

                    {{-- NAME EN --}}
                    <x-form.edit.input name="name_en" id="name_en" title="نام انگلیسی" placeholder="مثال: gram"
                        :required="true" msg="حداکثر 20 کاراکتر" :roles="['max-len' => 20]" :value="$unit->name_en" />

                    {{-- LABEL --}}
                    <x-form.edit.input name="label" id="label" title="نام نمایشی" placeholder="مثال: ق چ"
                        :required="true" msg="حداکثر 10 کاراکتر" :roles="['max-len' => 10]" :value="$unit->label" />

                </div>

                {{-- SUBMIT --}}
                <x-form.edit.submit title="ثبت تغییرات واحد اندازه گیری" />

            </form>
        </div>

    </div>

@endsection

@section('scripts')
    @vite(['resources/js/unit/edit.js'])
@endsection
