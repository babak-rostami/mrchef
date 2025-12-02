@extends('layouts.app')

@section('title', 'خانه')

@push('styles')
    @vite('resources/css/page/home.css')
@endpush

@section('content')

    <div class="md:mx-8 lg:mx-44">
        <div class="bslider pb-4" id="category-slider">
            @foreach ($categories as $category)
                <div
                    class="bslider-item category-slider-item cursor-pointer rounded-2xl ml-8 bg-white py-3
            hover:-translate-y-4 transition-all duration-300 ease-out">
                    <a href="/">
                        <div class="flex flex-col items-center">
                            <img class="w-24 h-24 object-contain" src="{{ $category->image_url }}" alt="{{ $category->name }}">
                            <span class="font-bold mt-4 text-gray-500">{{ $category->name }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

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
                    <a href="/">
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

        <div class="grid grid-cols-1 md:grid-cols-[auto_1fr] mt-4 rounded-2xl overflow-hidden items-start">

            <!-- IMAGE -->
            <div class="flex justify-center md:block">
                <img class="w-11/12 md:w-auto md:h-64 object-contain rounded-2xl md:rounded-none" src="{{ $sigleRecipe->image_url }}" alt="pizza">
            </div>

            <!-- TEXT BOX -->
            <div class="flex flex-col items-start p-4 gap-4 bg-gray-100
            rounded-2xl md:rounded-none
            mt-4 md:mt-0 md:h-full w-full">
                <span class="text-3xl font-extrabold text-gray-600">{{ $sigleRecipe->title }}</span>

                <span class="whitespace-pre-line">{{ $sigleRecipe->description }}</span>

                <a href="/recipes"
                    class="group flex items-center gap-2 bg-white text-green-700
            px-4 py-2 rounded-3xl hover:bg-green-800 hover:text-white">
                    <span>دستور پخت</span>
                    <img class="bg-green-900 rounded-2xl p-1" src="{{ asset('files/icon/arrow-left-24.png') }}"
                        alt="arrow">
                </a>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
            <img src="{{ asset('files/images/behnam.jpg') }}" alt="mrchef" class="w-full object-contain rounded-2xl">
            <div class="flex flex-col justify-center bg-gray-100 rounded-2xl
            p-8">
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

@push('scripts')
    @vite('resources/js/page/home.js')
@endpush
