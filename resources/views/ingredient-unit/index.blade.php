@extends('layouts.app')

@section('title', 'واحد های اندازه گیری')

@section('styles')
    @vite(['resources/css/ingredient-unit/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="واحد های اندازه گیری" :parents="[['url' => route('admin.ingredient.index'), 'title' => 'مواد اولیه']]" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-40 mt-8">

        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">وزن واحد های {{ $ingredient->name }}</h3>

            <button onclick="openModal('createIngredientUnit')"
                class="px-4 py-1.5 cursor-pointer bg-blue-500 mr-2 text-white rounded-xl shadow hover:bg-blue-600">
                اضافه کردن
            </button>

            <x-modal id="createIngredientUnit">
                <h2 class="text-xl font-bold mb-3">اضافه کردن وزن واحد اندازه گیری</h2>
                <span class="text-blue-400">مثلا 1 قاشق غذاخوری شکر = 12 گرم</span>
                <br>
                <span class="text-blue-400">مثلا 1 لیوان برنج = 150 گرم</span>

                <div class="flex justify-center mt-4">
                    <form id="ingredient-unit-store-form"
                        action="{{ route('admin.ingredient.units.store', $ingredient->slug) }}" method="POST"
                        enctype="multipart/form-data" class="w-full space-y-6">
                        @csrf
                        {{-- SELECT UNIT --}}
                        <x-form.create.select title="واحد اندازه گیری" name="unit_id" id="unit_id" :required="true"
                            default="یک واحد اندازه گیری انتخاب کنید..." :items="$units" itemsName="name" />

                        {{-- unit weight --}}
                        <x-form.create.number name="unit_weight_in_gram" id="unit_weight_in_gram"
                            title="وزن هر واحد (به گرم)" :required="true" placeholder="مثال: 16"
                            msg="هر واحد از این ماده چند گرم است؟" :roles="['min-number' => 1, 'max-number' => 500000]" />

                        {{-- SUBMIT --}}
                        <x-form.create.submit title="ثبت وزن واحد اندازه گیری" />
                    </form>
                </div>
            </x-modal>

        </div>

        <!-- ingredient List -->
        @if ($ingredient->units->count() == 0)
            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500 mb-4">وزن واحد های اندازه گیری ثبت نشده</h5>

                <button onclick="openModal('createIngredientUnit')"
                    class="px-4 py-1.5 cursor-pointer bg-blue-500 mr-2 text-white rounded-xl shadow hover:bg-blue-600">
                    اضافه کردن وزن واحد اندازه گیری
                </button>
            </div>
        @else
            <x-partials.table.index id="ingredient_units" :columns="[
                ['key' => 'id', 'label' => 'id', 'sortable' => true],
                ['key' => 'name', 'label' => 'واحد اندازه گیری', 'sortable' => true],
                [
                    'key' => 'unit_weight',
                    'label' => 'وزن واحد به گرم',
                    'sortable' => true,
                    'searchable' => true,
                    'view' => 'ingredient-unit.part.table.unit_weight',
                ],
                ['key' => 'actions', 'label' => '#', 'view' => 'ingredient-unit.part.table.actions'],
            ]" :rows="$ingredient->units" />
        @endif

    </div>

@endsection

@section('scripts')
    @vite(['resources/js/ingredient-unit/index.js'])
@endsection
