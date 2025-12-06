@extends('layouts.app')

@section('title', 'مدیریت مواد اولیه')

@push('styles')
    @vite('resources/css/ingredient/index.css')
@endpush

@section('content')

    <x-partials.breadcrumb panel="admin" page="مدیریت مواد اولیه" />

    <div class="md:mx-8 lg:mx-44">

        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">مدیریت مواد اولیه</h3>

            <a href="{{ route('admin.ingredient.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                <i class="fa fa-plus ml-1"></i>
                ماده اولیه جدید
            </a>

        </div>

        <!-- ingredient List -->
        <div class="mt-6">

            @if ($ingredients->count() == 0)

                <div class="flex flex-col items-center py-10 mb-32">
                    <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                    <h5 class="text-gray-500">هنوز ماده اولیه ایجاد نکرده اید</h5>

                    <a href="{{ route('admin.ingredient.create') }}"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                        <i class="fa fa-plus ml-1"></i>
                        ایجاد اولین ماده اولیه
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-32">

                    @foreach ($ingredients as $ingredient)
                        <div
                            class="p-4 bg-white shadow-sm hover:shadow-lg rounded-2xl flex flex-col">

                            <!-- Image + Title -->
                            <div class="flex items-center mb-3">
                                <img src="{{ $ingredient->thumb_url }}" class="w-16 h-16 rounded-lg object-cover">
                                <div class="mr-3 flex flex-col items-start gap-2">
                                    <h6 class="font-bold">{{ $ingredient->name }}</h6>
                                    <span class="font-bold">{{ $ingredient->slug }}</span>
                                    @if ($ingredient->show_in_search == 1)
                                        @include('components.helper.badge', [
                                            'title' => 'نمایش در فیلتر جستجو',
                                            'class' => 'success',
                                        ])
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-center mt-auto pt-3">

                                <a href="{{ route('admin.ingredient.edit', $ingredient->slug) }}"
                                    class="px-4 py-1.5 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600">
                                    ویرایش
                                </a>

                                <a href="{{ route('admin.ingredient.units.index', $ingredient->slug) }}"
                                    class="px-4 py-1.5 mx-2 bg-blue-500 text-white rounded-xl shadow hover:bg-blue-600">
                                    واحد های اندازه گیری
                                </a>

                                {{-- <button onclick="openModal('deleteIngredient-{{ $ingredient->id }}')"
                                class="px-4 py-1.5 cursor-pointer bg-red-500 mr-2 text-white rounded-xl shadow hover:bg-red-600">
                                حذف ماده اولیه
                            </button>

                            <x-modal id="deleteIngredient-{{ $ingredient->id }}">
                                <h2 class="text-xl font-bold mb-3">حذف ماده اولیه</h2>

                                <form action="{{ route('admin.ingredient.destroy', $ingredient->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="flex flex-col mt-2 mb-4">
                                        <span>{{ $ingredient->name }}</span>
                                        <span class="text-red-600 font-bold">هشدار</span>
                                        <span>مطمئنید میخواهید ماده اولیه حذف شود؟</span>
                                    </div>

                                    <div class="flex">
                                        <button type="button"
                                            onclick="closeModal('deleteIngredient-{{ $ingredient->id }}')"
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
    </div>

@endsection

@push('scripts')
    @vite('resources/js/ingredient/index.js')
@endpush
