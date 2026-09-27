@extends('layouts.app')

@section('title', 'Mrchef | رسپی و دستور پخت غذای خانگی')
@section('meta_description', 'رسپی و دستور پخت غذای خانگی، قدم‌به‌قدم و با مواد اولیه مشخص. هر هفته رسپی‌های تازه از Mrchef.')

@push('styles')
    @vite(['resources/css/page/home.css'])
@endpush

@section('content')

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        {{-- category slider --}}
        <x-category.category-slider :categories="$categories" route="recipes.index" />

        {{-- بنر بالای صفحه --}}
        <section aria-labelledby="home-hero-title" class="relative w-full rounded-3xl overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ config('images.ftp_path') . '/files/images/bigloveroast.jpg' }}"
                    class="w-full h-full object-cover" alt="آشپزی با بهنام رستمی">
                <div class="absolute inset-0 bg-black/60"></div> <!-- لایه تاریک روی عکس -->
            </div>
            <div class="relative z-10 w-full py-14 px-8 flex flex-col items-center md:items-start text-white">
                {{-- h1 صفحه اصلی، قبلاً h2 بود و اصلاً h1 توی این صفحه نبود --}}
                <h1 id="home-hero-title"
                    class="text-3xl md:text-5xl drop-shadow-2xl font-black mb-4 text-center md:text-right">
                    بهشت زیر دست آشپزهاست و بس
                </h1>
                <p class="text-lg md:text-xl max-w-2xl opacity-95 mb-8 text-center md:text-right leading-relaxed">
                    با ساده‌ترین مواد، خوشمزه‌ترین خاطره‌ها رو بسازید.
                </p>
                <a href="{{ route('recipes.index') }}"
                    class="group flex items-center gap-2 bg-white text-green-700 px-4 py-4 rounded-3xl hover:bg-green-800 hover:text-white">
                    <span>امروز چی بپزم؟</span>
                    <img class="bg-green-900 rounded-2xl p-1"
                        src="{{ config('images.ftp_path') . '/files/icon/arrow-left-24.png' }}" alt="" aria-hidden="true">
                </a>
            </div>
        </section>


        {{-- recipes slider --}}
        <section aria-labelledby="weekly-recipes-title" class="mt-8">
            <h2 id="weekly-recipes-title" class="text-3xl font-extrabold text-gray-500">رسپی های این هفته</h2>
            <ul class="bslider py-4" id="recipe-slider">
                @foreach ($recipes as $recipe)
                    <li class="bslider-item recipe-slider-item cursor-pointer ml-8 bg-white p-3
                                            hover:-translate-y-4 transition-all duration-300 ease-out">
                        <a href="{{ route('recipes.show', $recipe->slug) }}">
                            <div class="flex flex-col items-start">
                                <img class="w-48 h-48 object-contain rounded-2xl" src="{{ $recipe->image_url }}"
                                    alt="{{ $recipe->title }}">
                                <span class="mt-4">{{ $recipe->title }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- رسپی پیشنهادی --}}
        <x-recipes.single-recipe-horizontal :recipe="$sigleRecipe" />


        {{-- about site mrchef --}}
        <section aria-label="معرفی Mrchef" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
            <img src="{{ config('images.ftp_path') . '/files/images/behnam.jpg' }}" alt="آشپزخونه بهنام" class="w-full object-contain rounded-2xl
                            hover:scale-95 duration-300">
            <div class="flex flex-col justify-center bg-gray-100 rounded-2xl
                            p-8 hover:scale-95 duration-300">
                {{-- قبلاً span بود، برای درست بودن ساختار سرتیتر h2 شد --}}
                <h2 class="font-extrabold text-gray-600 text-center
                                text-4xl">آشپزخونه بهنام</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line
                                text-center">
                    آشپزی می‌تونه ساده و لذت‌بخش باشه
                    حتی با محدودترین مواد اولیه
                    هر کسی می‌تونه با کمی خلاقیت و عشق توی آشپزخونه معجزه کنه
                </p>
                <a href="{{ route('about') }}" class="mt-4 text-emerald-700 font-bold hover:underline mx-auto">
                    بیشتر بدونید ←
                </a>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    @vite(['resources/js/page/home.js'])
@endpush