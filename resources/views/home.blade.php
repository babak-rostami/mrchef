@extends('layouts.app')

@section('title', 'خانه')

@section('styles')
    @vite(['resources/css/page/home.css'])
@endsection

@section('content')

    <div class="md:mx-8 lg:mx-44">

        {{-- category slider --}}
        <x-category.category-slider :categories="$categories" route="recipes.index" />

        <!-- بنر بالای صفحه -->
        <div class="relative w-full rounded-3xl overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ asset('files/images/bigloveroast.jpg') }}" class="w-full h-full object-cover"
                    alt="آشپزی با بهنام رستمی">
                <div class="absolute inset-0 bg-black/60"></div> <!-- لایه تاریک روی عکس -->
            </div>
            <div class="relative z-10 w-full py-14 px-8 flex flex-col items-center md:items-start text-white">
                <h2 class="text-3xl md:text-5xl drop-shadow-2xl font-black mb-4 text-center md:text-right">
                    بهشت زیر دست آشپزهاست و بس
                </h2>
                <p class="text-lg md:text-xl max-w-2xl opacity-95 mb-8 text-center md:text-right leading-relaxed">
                    با ساده‌ترین مواد، خوشمزه‌ترین خاطره‌ها رو بسازید.
                </p>
                <a href="/recipes"
                    class="group flex items-center gap-2 bg-white text-green-700 px-4 py-4 rounded-3xl hover:bg-green-800 hover:text-white">
                    <span>امروز چی بپزم؟</span>
                    <img class="bg-green-900 rounded-2xl p-1" src="{{ asset('files/icon/arrow-left-24.png') }}"
                        alt="arrow">
                </a>
            </div>
        </div>


        {{-- recipes slider --}}
        <h2 class="mt-8 text-3xl font-extrabold text-gray-500">رسپی های این هفته</h2>
        <div class="bslider py-4" id="recipe-slider">
            @foreach ($recipes as $recipe)
                <div
                    class="bslider-item recipe-slider-item cursor-pointer ml-8 bg-white p-3
            hover:-translate-y-4 transition-all duration-300 ease-out">
                    <a href="{{ route('recipes.show', $recipe->slug) }}">
                        <div class="flex flex-col items-start">
                            <img class="w-48 h-48 object-contain rounded-2xl" src="{{ $recipe->image_url }}"
                                alt="{{ $recipe->title }}">
                            <span class="mt-4">{{ $recipe->title }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- رسپی پیشنهادی --}}
        <x-recipes.single-recipe-horizontal :recipe="$sigleRecipe" />


        {{-- about site mrchef --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
            <img src="{{ asset('files/images/behnam.jpg') }}" alt="mrchef"
                class="w-full object-contain rounded-2xl
            hover:scale-95 duration-300">
            <div class="flex flex-col justify-center bg-gray-100 rounded-2xl
            p-8 hover:scale-95 duration-300">
                <span class="font-extrabold text-gray-600 text-center
                text-4xl">آشپزخونه بهنام</span>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line
                text-center">
                    آشپزی می‌تونه ساده و لذت‌بخش باشه
                    حتی با محدودترین مواد اولیه
                    هر کسی می‌تونه با کمی خلاقیت و عشق توی آشپزخونه معجزه کنه
                </p>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    @vite(['resources/js/page/home.js'])
@endsection
