@extends('layouts.app')

@section('title', 'واحد های اندازه گیری')

@section('styles')
    @vite(['resources/css/unit/index.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="admin" page="واحد های اندازه گیری" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-12 mt-8">

        <!-- Title + Create Button -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">واحد های اندازه گیری</h3>

            <a href="{{ route('admin.unit.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                <i class="fa fa-plus ml-1"></i>
                واحد اندازه گیری جدید
            </a>

        </div>

        <!-- unit List -->
        @if ($units->count() == 0)

            <div class="flex flex-col items-center py-10">
                <img src="{{ asset('files/icon/empty-list.png') }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هیچ واحد اندازه گیری ای یافت نشد</h5>

                <a href="{{ route('admin.unit.create') }}"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">
                    <i class="fa fa-plus ml-1"></i>
                    ایجاد اولین واحد اندازه گیری
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach ($units as $unit)
                    <div class="p-4 bg-white shadow-sm hover:shadow-lg rounded-2xl flex flex-col">

                        <!-- Image + Title -->
                        <div class="flex items-center mb-3 gap-4 justify-center">
                            <span class="font-bold">{{ $unit->name }}</span>
                            <span class="font-bold">{{ $unit->name_en }}</span>
                            <span class="font-bold">{{ $unit->label }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-auto pt-3">

                            <a href="{{ route('admin.unit.edit', $unit->id) }}"
                                class="px-4 py-1.5 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600">
                                ویرایش
                            </a>

                            {{-- <button onclick="openModal('deleteUnit-{{ $unit->id }}')"
                                class="px-4 py-1.5 cursor-pointer bg-red-500 mr-2 text-white rounded-xl shadow hover:bg-red-600">
                                حذف واحد اندازه گیری
                            </button>

                            <x-modal id="deleteUnit-{{ $unit->id }}">
                                <h2 class="text-xl font-bold mb-3">حذف واحد اندازه گیری</h2>

                                <form action="{{ route('admin.unit.destroy', $unit->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="flex flex-col mt-2 mb-4">
                                        <span>{{ $unit->name }}</span>
                                        <span class="text-red-600 font-bold">هشدار</span>
                                        <span>مطمئنید میخواهید واحد اندازه گیری حذف شود؟</span>
                                    </div>

                                    <div class="flex">
                                        <button type="button" onclick="closeModal('deleteUnit-{{ $unit->id }}')"
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
    @vite(['resources/js/unit/index.js'])
@endsection
