@extends('layouts.app')

@section('title', 'مواد اولیه')

@push('styles')
    @vite('resources/css/recipe-ingredient/index.css')
@endpush

@section('content')

    @include('partials.breadcrumb', [
        'breadcrumb_title' => 'مواد اولیه',
        'breadcrumb_parents' => [
            [
                'url' => route('admin.recipes.index'),
                'title' => 'طرز پخت',
            ],
        ],
    ])

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
                <form id="recipe-ingredient-store-form" action="{{ route('admin.recipe.ingredients.store', $recipe->id) }}"
                    method="POST" enctype="multipart/form-data" class="w-full space-y-6">
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
    <div class="bg-white rounded-2xl shadow p-6 mt-6">

        @if ($r_ingredients->count() == 0)
            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">مواد اولیه ثبت نشده</h5>

                <button onclick="openModal('createRecipeIngredient')"
                    class="px-4 py-1.5 cursor-pointer bg-blue-500 mr-2 text-white rounded-xl shadow hover:bg-blue-600">
                    اضافه کردن مواد اولیه
                </button>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($r_ingredients as $ri)
                    <div
                        class="p-4 bg-white border border-gray-400 rounded-2xl
                    hover:shadow-md transition flex flex-col">

                        <!-- Title -->
                        <div class="mr-3 mb-3 flex gap-2">
                            <span class="font-bold">{{ $ri->name }}</span>
                            <span class="font-bold">{{ $ri->amount }}</span>
                            <span class="font-bold">{{ $ri->unit_name }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-auto pt-3">

                            <button onclick="openModal('editIngredientUnit-{{ $ri->id }}')"
                                class="px-4 py-1.5 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600">
                                ویرایش
                            </button>
                            <x-modal id="editIngredientUnit-{{ $ri->id }}">
                                <h2 class="text-xl font-bold mb-3">ویرایش</h2>

                                <form id="recipe-ingredient-update-form-{{ $ri->id }}"
                                    action="{{ route('admin.recipe.ingredients.update', ['recipe' => $recipe->id, 'ingredient' => $ri->id]) }}"
                                    method="POST" enctype="multipart/form-data"
                                    class="w-full space-y-6 recipe-ingredient-update-form">
                                    @csrf
                                    @method('PUT')

                                    {{-- SELECT unit --}}
                                    <x-form.edit.readonly title="واحد اندازه گیری" id="unit_id-{{ $ri->id }}"
                                        :value="$ri->unit_name" />

                                    {{-- amount --}}
                                    <x-form.edit.number name="amount" id="amount-{{ $ri->id }}" title="مقدار لازم"
                                        :required="true" placeholder="مثال: 16" msg="مقدار لازم را وارد کنید"
                                        :value="$ri->amount" :roles="['min-number' => 1, 'max-number' => 500000]" />

                                    {{-- SUBMIT --}}
                                    <x-form.edit.submit title="ویرایش مقدار لازم" />
                                </form>

                            </x-modal>

                            <button onclick="openModal('deleteRecipeIngredient-{{ $ri->id }}')"
                                class="px-4 py-1.5 cursor-pointer bg-red-500 mr-2 text-white rounded-xl shadow hover:bg-red-600">
                                حذف مقدار لازم
                            </button>

                            <x-modal id="deleteRecipeIngredient-{{ $ri->id }}">
                                <h2 class="text-xl font-bold mb-3">حذف مقدار لازم</h2>

                                <form
                                    action="{{ route('admin.recipe.ingredients.destroy', ['recipe' => $recipe->id, 'ingredient' => $ri->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="flex flex-col mt-2 mb-4">
                                        <span>{{ $ri->name }}</span>
                                        <span class="text-red-600 font-bold">هشدار</span>
                                        <span>مطمئنید میخواهید ماده اولیه حذف شود؟</span>
                                    </div>

                                    <div class="flex">
                                        <button type="button"
                                            onclick="closeModal('deleteRecipeIngredient-{{ $ri->id }}')"
                                            class="bg-gray-400 hover:bg-gray-500 cursor-pointer text-white px-4 py-2 rounded">
                                            نمیخواهم حذف شود
                                        </button>

                                        <button type="submit" onclick="submitForm(this,'در حال حذف...')"
                                            class="bg-red-600 hover:bg-red-400 cursor-pointer mr-2 text-white px-4 py-2 rounded">
                                            حذف شود
                                        </button>
                                    </div>
                                </form>
                            </x-modal>

                        </div>

                    </div>
                @endforeach

            </div>
        @endif

    </div>

@endsection

@push('scripts')
    @vite('resources/js/recipe-ingredient/index.js')
@endpush
