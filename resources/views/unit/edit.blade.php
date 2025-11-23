@extends('layouts.app')

@section('title', 'واحد اندازه گیری جدید')

@push('styles')
    @vite('resources/css/unit/edit.css')
@endpush

@section('content')

    <div class="mx-auto px-4">
        @include('partials.breadcrumb', [
            'breadcrumb_title' => 'واحد اندازه گیری جدید',
            'breadcrumb_parents' => [
                [
                    'url' => route('unit.index'),
                    'title' => 'مدیریت مواد اولیه',
                ],
            ],
        ])


        <!-- Title -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش واحد اندازه گیری</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="unit-update-form" action="{{ route('unit.update', $unit->id) }}" method="POST"
                    enctype="multipart/form-data" class="w-full space-y-6">
                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- NAME --}}
                        @include('components.form.edit.input', [
                            'binput_title' => 'نام',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: گرم',
                            'binput_msg' => 'حداکثر 20 کاراکتر',
                            'binput_name' => 'name',
                            'binput_role' => ['max-length' => 20],
                            'binput_value' => $unit->name,
                        ])

                        {{-- NAME EN --}}
                        @include('components.form.edit.input', [
                            'binput_title' => 'نام انگلیسی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: gram',
                            'binput_msg' => 'حداکثر 20 کاراکتر',
                            'binput_name' => 'name_en',
                            'binput_role' => ['max-length' => 20],
                            'binput_value' => $unit->name_en,
                        ])

                        {{-- NAME EN --}}
                        @include('components.form.edit.input', [
                            'binput_title' => 'نام نمایشی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: ق چ',
                            'binput_msg' => 'حداکثر 10 کاراکتر',
                            'binput_name' => 'label',
                            'binput_role' => ['max-length' => 10],
                            'binput_value' => $unit->label,
                        ])

                    </div>

                    {{-- SUBMIT --}}
                    @include('components.form.edit.submit', [
                        'submit_title' => 'ثبت تغییرات واحد اندازه گیری',
                    ])
                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/unit/edit.js')
@endpush
