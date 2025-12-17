@extends('layouts.app')

@section('title', 'رسپی ها')

@section('styles')
    @vite(['resources/css/frontend/recipe/show.css'])
@endsection

@section('content')

    <x-partials.breadcrumb panel="user" page="{{ $recipe->title }}" :parents="[['url' => route('recipes.index'), 'title' => 'رسپی ها']]" />

    <!-- container -->
    <div class="md:mx-8 lg:mx-44">

        {{-- category slider --}}

        <div class="flex justify-center">
            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}"
                class="h-96 rounded-2xl
                                                                                                                                                                                                                                                        hover:scale-105 duration-300">
        </div>
        <h1 class="text-2xl font-extrabold mt-8 mb-2">{{ $recipe->title }}</h1>
        <p class="whitespace-pre-line">{{ $recipe->description }}</p>

        @if (!$ingredients->isEmpty())
            <div class="bg-gray-100 p-4 rounded-2xl mt-4">
                <h2 class="text-2xl font-extrabold mb-2">مواد اولیه</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                    @foreach ($ingredients as $ingredient)
                        <div
                            class="flex items-center bg-white
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    px-4 py-3 my-2 rounded-3xl
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    hover:-translate-y-3 duration-300">
                            <img class="w-14 ml-4" src="{{ $ingredient->thumb_url }}" alt="{{ $ingredient->name }}">
                            <span class="text-[18px]">{{ $ingredient->name }}</span>
                            <div class="mr-auto">
                                <span class="text-[20px]">{{ $ingredient->amount }}</span>
                                <span>{{ $ingredient->unit_name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-3 text-center mt-4 gap-2">
            <div
                class="flex flex-col bg-gray-50 rounded-2xl p-4 gap-2
                                                                                                                                                                                                                                                        hover:translate-y-2 duration-300">
                <span class="font-extrabold text-[18px]">آماده سازی</span>
                <span>{{ $recipe->time_prepare }} دقیقه</span>
            </div>
            <div
                class="flex flex-col bg-gray-50 rounded-2xl p-4 gap-2
                                                                                                                                                                                                                                                        hover:translate-y-2 duration-300">
                <span class="font-extrabold text-[18px]">زمان کل</span>
                <span>{{ $recipe->time_cook }} دقیقه</span>
            </div>
            <div
                class="flex flex-col bg-gray-50 rounded-2xl p-4 gap-2
                                                                                                                                                                                                                                                        hover:translate-y-2 duration-300">
                <span class="font-extrabold text-[18px]">تعداد نفرات</span>
                <span>{{ $recipe->servings }} نفر</span>
            </div>
        </div>

        <div class="mt-8" id="recipe-body">
            {!! $recipe->body !!}
        </div>

        <x-comment.section page="recipe" :object="$recipe" :comments="$comments" />

        {{-- <form action="{{ route('comment.store') }}" method="post" id="store-comment-form">

            @csrf

            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

            <textarea id="comment-textarea" name="body" placeholder="نظر خود را اینجا بنویسید..."
                class="w-full border border-gray-200 outline-0 rounded-2xl
                                                                                                hover:shadow-blue-100 hover:shadow-md duration-300 mt-8
                                                                                                focus:outline-4 focus:outline-blue-200
                                                                                                text-2xl h-36 p-4 resize-none"></textarea>

            <!-- نمایش پیام خطا -->
            <div id="comment-error" class="bg-red-100 text-lg mb-2 pr-2 py-2 rounded hidden"></div>
            @error('body')
            <p class="bg-red-100 text-lg mb-2 pr-2 py-2 rounded">{{ $message }}</p>
            @enderror
            <input type="submit" value="ثبت نظر"
                class="w-full bg-blue-500 text-white rounded-2xl
                                                                                                py-2 text-2xl cursor-pointer hover:bg-blue-600">
        </form>


        <div id="comments-box" class="mb-48">
            <x-comment.comment-item :has_reply="1" :is_reply="0" />
        </div> --}}
    </div>

@endsection

@section('scripts')
    @vite(['resources/js/frontend/recipe/show.js'])
@endsection
