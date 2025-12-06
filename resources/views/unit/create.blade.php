@extends('layouts.app')

@section('title', 'واحد اندازه گیری جدید')

@push('styles')
    @vite('resources/css/unit/create.css')
@endpush

@section('content')

    <div class="mx-auto px-4">

        <x-partials.breadcrumb panel="admin" page="واحد اندازه گیری جدید" :parents="[['url' => route('admin.unit.index'), 'title' => 'واحد های اندازه گیری']]" />

        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">واحد اندازه گیری جدید</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="unit-store-form" action="{{ route('admin.unit.store') }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- NAME --}}
                        <x-form.create.input name="name" id="name" title="نام" placeholder="مثال: گرم"
                            :required="true" msg="حداکثر 20 کاراکتر" :roles="['max-len' => 20]" />

                        {{-- NAME EN --}}
                        <x-form.create.input name="name_en" id="name_en" title="نام انگلیسی" placeholder="مثال: gram"
                            :required="true" msg="حداکثر 20 کاراکتر" :roles="['max-len' => 20]" />

                        {{-- LABEL --}}
                        <x-form.create.input name="label" id="label" title="نام نمایشی" placeholder="مثال: ق چ"
                            :required="true" msg="حداکثر 10 کاراکتر" :roles="['max-len' => 10]" />

                    </div>

                    {{-- SUBMIT --}}
                    <x-form.create.submit title="ثبت واحد اندازه گیری" />

                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/unit/create.js')
@endpush
