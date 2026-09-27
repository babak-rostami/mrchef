@extends('layouts.app')

{{-- قبلاً title/description هر دسته‌بندی دقیقاً یکی بود (محتوای تکراری، بد برای سئو)
الان هر دسته‌بندی عنوان و توضیح اختصاصی خودش رو داره --}}
@section('title', isset($category) ? $category->name . ' | رسپی‌های ' . $category->name . '' : 'رسپی ها')
@section(
    'meta_description',
    isset($category)
    ? 'رسپی و دستور پخت ' . $category->name . '، قدم‌به‌قدم و با مواد اولیه مشخص.'
    : 'مجموعه رسپی و دستور پخت غذای خانگی Mrchef، دسته‌بندی‌شده و قدم‌به‌قدم.'
)

@push('styles')
    @vite(['resources/css/frontend/recipe/index.css'])
@endpush

@section('content')

    @if (isset($category))
        <x-partials.breadcrumb panel="user" page="{{ $category->name }}" :parents="[['url' => route('recipes.index'), 'title' => 'رسپی ها']]" />
    @else
        <x-partials.breadcrumb panel="user" page="رسپی ها" />
    @endif

    <!-- container -->
    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        {{-- category slider --}}
        <x-category.category-slider :categories="$categories" route="recipes.index" />

        <section aria-labelledby="recipes-hero-title" class="relative w-full rounded-3xl overflow-hidden mb-8">
            <div class="absolute inset-0">
                <img src="{{ config('images.ftp_path') . '/files/images/recipe-index.jpg' }}"
                    class="w-full h-full object-cover"
                    alt="{{ isset($category) ? $category->name : 'امروز غذا چی بپزم؟' }}">
                <div class="absolute inset-0 bg-black/40"></div> <!-- لایه تاریک روی عکس -->
            </div>
            <div class="relative z-10 w-full py-32 px-8 flex flex-col items-center md:items-start text-white">
                <h1 id="recipes-hero-title"
                    class="text-4xl md:text-6xl drop-shadow-2xl font-black mb-4 text-center md:text-right">
                    {{ isset($category) ? $category->name : 'امروز غذا چی بپزم؟' }}
                </h1>
                <p class="text-lg md:text-2xl max-w-2xl opacity-95 text-center md:text-right leading-relaxed">
                    از بین این غذاهای خوشمزه انتخاب کن
                </p>
            </div>
        </section>


        @if ($recipes->count() == 0)

            <div class="flex flex-col items-center">
                <img src="{{ config('images.ftp_path') . '/files/images/behnam.jpg' }}" class="w-64 rounded-full mb-3
                                                        hover:-translate-y-2 duration-300 cursor-pointer" alt="آشپزخونه بهنام">
                <span class="text-2xl font-black block mb-2">رسپی های جدید تو راهه</span>
                <span>به دسته بندی های دیگه سر بزن</span>
            </div>
        @else
            <section aria-label="{{ isset($category) ? 'رسپی‌های ' . $category->name : 'همه رسپی‌ها' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($recipes as $recipe)
                        <x-recipes.single-recipe-index class="mb-80" :recipe="$recipe" />
                    @endforeach
                </div>
            </section>
        @endif

    </div>

@endsection

@push('scripts')
    @vite(['resources/js/frontend/recipe/index.js'])
@endpush

@if (!empty($recipesSchema))
    @push('schema')
        <x-schema-tag :data="$recipesSchema" />
    @endpush
@endif