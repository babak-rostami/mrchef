@extends('layouts.app')

@section('title', 'مواد اولیه')

@section('styles')
    @vite(['resources/css/recipe-ingredient/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="مواد اولیه" :parents="[['url' => route('admin.recipes.index'), 'title' => 'طرز پخت']]" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-48">
        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">مواد اولیه {{ $recipe->title }}</h3>

            <button onclick="openModal('createRecipeIngredient')"
                class="px-4 py-1.5 cursor-pointer bg-blue-500 mr-2 text-white rounded-xl shadow hover:bg-blue-600">
                اضافه کردن
            </button>

            <x-modal id="createRecipeIngredient">
                <h2 class="text-xl font-bold mb-3">اضافه کردن ماده اولیه</h2>
                <span class="text-blue-400">مثلا شیر 4 پیمانه</span>
                <br>
                <span class="text-blue-400">مثلا تخم مرغ 2 عدد</span>

                <div class="flex justify-center mt-4">
                    <form id="recipe-ingredient-store-form"
                        action="{{ route('admin.recipe.ingredients.store', $recipe->id) }}" method="POST"
                        enctype="multipart/form-data" class="w-full space-y-6">
                        @csrf
                        {{-- SELECT ingredient --}}
                        <x-form.create.select title="ماده اولیه" name="ingredient_id" id="ingredient_id" :required="true"
                            default="یک ماده اولیه انتخاب کنید..." :items="$ingredients" itemsName="name" />

                        {{-- SELECT unit --}}
                        <x-form.create.select title="واحد اندازه گیری" name="unit_id" id="unit_id" :required="true"
                            default="یک واحد اندازه گیری انتخاب کنید..." :items="[]" itemsName="name" />

                        {{-- amount --}}
                        <x-form.create.number name="amount" id="amount" title="مقدار لازم" :required="true"
                            placeholder="مثال: 16" msg="مقدار لازم را وارد کنید" :roles="['min-number' => 1, 'max-number' => 500000]" />

                        {{-- SUBMIT --}}
                        <x-form.create.submit title="ثبت وزن واحد اندازه گیری" />
                    </form>
                </div>
            </x-modal>

        </div>

        <!-- ingredient List -->
        @if ($r_ingredients->count() == 0)
            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500 mb-4">مواد اولیه ثبت نشده</h5>

                <button onclick="openModal('createRecipeIngredient')"
                    class="px-4 py-1.5 cursor-pointer bg-blue-500 mr-2 text-white rounded-xl shadow hover:bg-blue-600">
                    اضافه کردن مواد اولیه
                </button>
            </div>
        @else
            <x-partials.table.index id="r_ingredients" :columns="[
                ['key' => 'id', 'label' => 'id', 'sortable' => true],
                [
                    'key' => 'title',
                    'label' => 'مقدار لازم',
                    'sortable' => true,
                    'searchable' => true,
                    'view' => 'recipe-ingredient.part.table.title',
                ],
                ['key' => 'actions', 'label' => '#', 'view' => 'recipe-ingredient.part.table.actions'],
            ]" :rows="$r_ingredients" />
        @endif

    </div>

@endsection

@section('scripts')
    @vite(['resources/js/recipe-ingredient/index.js'])
@endsection
