@extends('layouts.app')

@section('title', $recipe->title)
@section('meta_description', \Illuminate\Support\Str::limit($recipe->description, 155))
@section('og_type', 'article')
@section('og_image', $recipe->image_url)

@push('styles')
    @vite(['resources/css/frontend/recipe/show.css'])
@endpush

@section('content')

    <x-partials.breadcrumb panel="user" page="{{ $recipe->title }}" :parents="[
            ['url' => route('recipes.index'), 'title' => 'رسپی ها'],
            ['url' => route('recipes.index', $recipe->category->slug), 'title' => $recipe->category->name],
        ]" />

    <!-- container -->
    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <article>

            @if ($recipe->aparat_url)
                <section class="border-b border-slate-200 p-6 sm:p-8">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                        <div class="aspect-video">
                            {!! $recipe->aparat_url !!}
                        </div>
                    </div>
                </section>
            @else
                <div class="flex mt-8">
                    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}"
                        class="h-96 rounded-2xl hover:scale-105 duration-300">
                </div>
            @endif

            <h1 class="text-2xl font-extrabold mt-8 mb-2">{{ $recipe->title }}</h1>
            <p class="whitespace-pre-line">{{ $recipe->description }}</p>

            @if (!$ingredients->isEmpty())
                <section aria-labelledby="ingredients-title" class="bg-gray-100 p-4 rounded-2xl mt-4">
                    <h2 id="ingredients-title" class="text-2xl font-extrabold mb-2">مواد اولیه</h2>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                        @foreach ($ingredients as $ingredient)
                            <li class="flex items-center bg-white px-4 py-3 my-2 rounded-3xl hover:-translate-y-3 duration-300">
                                <img class="w-14 ml-4" src="{{ $ingredient->image_url }}" alt="{{ $ingredient->name }}"
                                    loading="lazy">
                                <span class="text-[18px]">{{ $ingredient->name }}</span>
                                <div class="mr-auto">
                                    <span class="text-[20px]">{{ $ingredient->amount }}</span>
                                    <span>{{ $ingredient->unit_name }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            {{-- dl/dt/dd برای جفت‌های برچسب/مقدار، معنایی‌ترین تگ HTML برای این نوع داده‌ست --}}
            <dl class="grid grid-cols-3 text-center mt-4 gap-2">
                <div
                    class="flex flex-col bg-gray-50 rounded-2xl p-4 gap-2
                                                                                                hover:translate-y-2 duration-300">
                    <dt class="font-extrabold text-[18px]">آماده سازی</dt>
                    <dd>{{ $recipe->time_prepare }} دقیقه</dd>
                </div>
                <div
                    class="flex flex-col bg-gray-50 rounded-2xl p-4 gap-2
                                                                                                hover:translate-y-2 duration-300">
                    <dt class="font-extrabold text-[18px]">زمان کل</dt>
                    <dd>{{ $recipe->time_cook }} دقیقه</dd>
                </div>
                <div
                    class="flex flex-col bg-gray-50 rounded-2xl p-4 gap-2
                                                                                                hover:translate-y-2 duration-300">
                    <dt class="font-extrabold text-[18px]">تعداد نفرات</dt>
                    <dd>{{ $recipe->servings }} نفر</dd>
                </div>
            </dl>

            @if ($recipe->aparat_url)
                <div class="flex mt-8">
                    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}"
                        class="h-96 rounded-2xl hover:scale-105 duration-300">
                </div>
            @endif

            <section aria-labelledby="instructions-title" class="mt-8">
                <h2 id="instructions-title" class="text-2xl font-extrabold mb-4">طرز تهیه</h2>
                <div id="recipe-body">
                    {!! $recipe->body !!}
                </div>
            </section>

        </article>

        <x-comment.section page="recipe" :object="$recipe" :comments="$comments" :has_more_comments="$hasMoreComments" />

    </div>

@endsection

@push('scripts')
    @vite(['resources/js/frontend/recipe/show.js'])
@endpush

@push('schema')
    <x-schema-tag :data="$recipeSchema" />
@endpush