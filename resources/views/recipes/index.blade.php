@extends('layouts.app')

@section('title', 'مدیریت رسپی ها')

@push('styles')
    @vite('resources/css/recipe/index.css')
@endpush

@section('content')

    @include('partials.breadcrumb', ['breadcrumb_title' => 'مدیریت رسپی ها'])

    <!-- Title + Create Button -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold">مدیریت رسپی ها</h3>

        <a href="{{ route('admin.recipes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
            <i class="fa fa-plus ml-1"></i>
            رسپی جدید
        </a>

    </div>

    <!-- recipes List -->
    <div class="bg-white rounded-2xl shadow p-6 mt-6">

        @if ($recipes->count() == 0)

            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هیچ رسپی یافت نشد</h5>

                <a href="{{ route('admin.recipes.create') }}"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                    <i class="fa fa-plus ml-1"></i>
                    ایجاد اولین رسپی
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach ($recipes as $recipe)
                    <div
                        class="p-4 bg-white border border-gray-400 rounded-2xl
                    hover:shadow-md transition flex flex-col">

                        <!-- Image + Title -->
                        <div class="flex items-center mb-3">
                            <img src="{{ $recipe->thumb_url }}" class="w-16 h-16 rounded-lg object-cover">
                            <div class="mr-3 break-all">
                                <h6 class="font-bold">{{ $recipe->title }}</h6>
                            </div>
                        </div>

                        <div class="flex">
                            @if ($recipe->status == 0)
                                @include('components.helper.badge', [
                                    'title' => 'تایید نشده',
                                    'class' => 'danger',
                                ])
                            @elseif($recipe->status == 1)
                                @include('components.helper.badge', [
                                    'title' => 'تایید شده',
                                    'class' => 'success',
                                ])
                            @elseif($recipe->status == 2)
                                @include('components.helper.badge', [
                                    'title' => 'در انتظار',
                                    'class' => 'warning',
                                ])
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-auto pt-3">

                            <a href="{{ route('admin.recipes.edit', $recipe->slug) }}"
                                class="px-4 py-1.5 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600">
                                ویرایش
                            </a>

                            <a href="{{ route('admin.recipe.ingredients.index', $recipe->slug) }}"
                                class="px-4 py-1.5 mr-2 bg-sky-500 text-white rounded-xl shadow hover:bg-sky-600">
                                مواد اولیه
                            </a>


                            {{-- <button onclick="openModal('deleteRecipe-{{ $recipe->id }}')"
                                class="px-4 py-1.5 cursor-pointer bg-red-500 mr-2 text-white rounded-xl shadow hover:bg-red-600">
                                حذف رسپی
                            </button>

                            <x-modal id="deleteRecipe-{{ $recipe->id }}">
                                <h2 class="text-xl font-bold mb-3">حذف رسپی</h2>

                                <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="flex flex-col mt-2 mb-4">
                                        <span>{{ $recipe->title }}</span>
                                        <span class="text-red-600 font-bold">هشدار</span>
                                        <span>مطمئنید میخواهید رسپی حذف شود؟</span>
                                    </div>

                                    <div class="flex">
                                        <button type="button" onclick="closeModal('deleteRecipe-{{ $recipe->id }}')"
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


@push('scripts')
    @vite('resources/js/recipe/index.js')
@endpush
