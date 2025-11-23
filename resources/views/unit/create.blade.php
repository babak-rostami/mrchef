@extends('layouts.app')

@section('title', 'واحد اندازه گیری جدید')

@push('styles')
    @vite('resources/css/unit/create.css')
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
            <h3 class="text-xl font-bold">واحد اندازه گیری جدید</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-4">

            <div class="flex justify-center">
                <form id="unit-store-form" action="{{ route('unit.store') }}" method="POST" enctype="multipart/form-data"
                    class="w-full space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- NAME --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'نام',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: گرم',
                            'binput_msg' => 'حداکثر 20 کاراکتر',
                            'binput_name' => 'name',
                            'binput_role' => ['max-length' => 20],
                        ])

                        {{-- NAME EN --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'نام انگلیسی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: gram',
                            'binput_msg' => 'حداکثر 20 کاراکتر',
                            'binput_name' => 'name_en',
                            'binput_role' => ['max-length' => 20],
                        ])

                        {{-- LABEL --}}
                        @include('components.form.create.input', [
                            'binput_title' => 'نام نمایشی',
                            'bf_is_required' => true,
                            'binput_place' => 'مثال: ق چ',
                            'binput_msg' => 'حداکثر 10 کاراکتر',
                            'binput_name' => 'label',
                            'binput_role' => ['max-length' => 10],
                        ])

                    </div>

                    {{-- SUBMIT --}}
                    @include('components.form.create.submit', [
                        'submit_title' => 'ثبت واحد اندازه گیری',
                    ])

                </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/unit/create.js')
@endpush
