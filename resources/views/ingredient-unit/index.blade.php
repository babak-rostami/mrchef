@extends('layouts.app')

@section('title', 'واحد های اندازه گیری')

@section('styles')
    @vite(['resources/css/ingredient-unit/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="واحد های اندازه گیری" :parents="[['url' => route('admin.ingredient.index'), 'title' => 'مواد اولیه']]" />

    <div class="md:mx-8 lg:mx-44 mb-40 mt-8">

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
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($ingredient->units as $i_unit)
                    <div class="p-4 bg-white shadow-sm hover:shadow-lg rounded-2xl flex flex-col">

                        <!-- Title -->
                        <div class="mr-3 mb-3 flex flex-col items-start gap-2">
                            <span class="font-bold">{{ $i_unit->name }}</span>
                            <span class="font-bold">وزن واحد به گرم: {{ $i_unit->pivot->unit_weight_in_gram }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-auto pt-3">

                            <button onclick="openModal('editIngredientUnit-{{ $i_unit->id }}')"
                                class="px-4 py-1.5 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600">
                                ویرایش
                            </button>
                            <x-modal id="editIngredientUnit-{{ $i_unit->id }}">
                                <h2 class="text-xl font-bold mb-3">ویرایش</h2>

                                <form id="ingredient-unit-update-form-{{ $i_unit->id }}"
                                    action="{{ route('admin.ingredient.units.update', ['ingredient' => $ingredient->id, 'unit' => $i_unit->id]) }}"
                                    method="POST" enctype="multipart/form-data"
                                    class="w-full space-y-6 ingredient-unit-update-form">
                                    @csrf
                                    @method('PUT')

                                    {{-- unit weight --}}
                                    <x-form.edit.number name="unit_weight_in_gram"
                                        id="unit_weight_in_gram-{{ $i_unit->id }}" title="وزن هر واحد (به گرم)"
                                        :required="true" placeholder="مثال: 16" msg="هر واحد از این ماده چند گرم است؟"
                                        :roles="['min-number' => 1, 'max-number' => 500000]" :value="$i_unit->pivot->unit_weight_in_gram" />

                                    {{-- SUBMIT --}}
                                    <x-form.edit.submit title="ویرایش وزن واحد اندازه گیری" />
                                </form>

                            </x-modal>

                            {{-- <button onclick="openModal('deleteIngredient-{{ $i_unit->id }}')"
                                class="px-4 py-1.5 cursor-pointer bg-red-500 mr-2 text-white rounded-xl shadow hover:bg-red-600">
                                حذف وزن واحد
                            </button>

                            <x-modal id="deleteIngredient-{{ $i_unit->id }}">
                                <h2 class="text-xl font-bold mb-3">حذف وزن واحد</h2>

                                <form
                                    action="{{ route('admin.ingredient.units.destroy', ['ingredient' => $ingredient->id, 'unit' => $i_unit->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="flex flex-col mt-2 mb-4">
                                        <span>{{ $i_unit->name }}</span>
                                        <span class="text-red-600 font-bold">هشدار</span>
                                        <span>مطمئنید میخواهید ماده اولیه حذف شود؟</span>
                                    </div>

                                    <div class="flex">
                                        <button type="button" onclick="closeModal('deleteIngredient-{{ $i_unit->id }}')"
                                            class="bg-gray-400 hover:bg-gray-500 cursor-pointer text-white px-4 py-2 rounded">
                                            نمیخواهم حذف شود
                                        </button>

                                        <button type="submit" onclick="submitForm(this,'در حال حذف...')"
                                            class="bg-red-600 hover:bg-red-400 cursor-pointer mr-2 text-white px-4 py-2 rounded">
                                            حذف شود
                                        </button>
                                    </div>
                                </form>
                            </x-modal> --}}

                        </div>

                    </div>
                @endforeach

            </div>
        @endif

    </div>

@endsection

@section('scripts')
    @vite(['resources/js/ingredient-unit/index.js'])
@endsection
