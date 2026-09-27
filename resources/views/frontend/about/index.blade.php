@extends('layouts.app')

@section('title', 'درباره ما')
@section('meta_description', 'آشنایی با بهنام، چرا این سایت رو ساختیم، چه چیزی رسپی‌هامون رو متفاوت می‌کنه و چطور می‌تونید باهامون در ارتباط باشید.')
@section('meta_keywords', 'درباره ما, Mrchef, آشپزی با بهنام')

@section('content')

    <x-partials.breadcrumb panel="user" page="درباره ما" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-16">

        <article>
            {{-- هدر صفحه --}}
            <header class="relative w-full rounded-3xl overflow-hidden mb-10">
                <div class="absolute inset-0">
                    <img src="{{ config('images.ftp_path') . '/files/images/behnam.jpg' }}"
                        class="w-full h-full object-cover" alt="آشپزخونه Mrchef">
                    <div class="absolute inset-0 bg-black/50"></div>
                </div>
                <div class="relative z-10 py-20 px-8 text-center text-white">
                    <h1 class="text-4xl md:text-5xl font-black mb-4">درباره ما</h1>
                    <p class="text-lg md:text-xl max-w-2xl mx-auto opacity-95">
                        یه جای ساده برای یاد گرفتن آشپزی، با دستور پخت‌های قابل‌فهم و امتحان‌شده
                    </p>
                </div>
            </header>

            {{-- داستان --}}
            <section aria-labelledby="about-story-title" class="mb-10">
                <h2 id="about-story-title" class="text-2xl font-extrabold text-gray-600 mb-4">داستان ما</h2>
                {{-- TODO: این متن رو با داستان واقعی خودتون جایگزین کنید --}}
                <p class="leading-loose whitespace-pre-line">
                    Mrchef از دل یه علاقه‌ی ساده به آشپزی شروع شد: اینکه غذای خوشمزه لازم نیست پیچیده باشه.
                    هدف ما اینه که دستور پخت‌ها رو قدم‌به‌قدم، با مواد اولیه‌ی مشخص و زمان‌بندی دقیق توضیح بدیم
                    تا هرکسی، حتی کسی که تازه آشپزی رو شروع کرده، بتونه با اطمینان غذا بپزه.
                </p>
            </section>

            {{-- آمار سایت (واقعی، مستقیم از دیتابیس) --}}
            <section aria-label="آمار سایت" class="grid grid-cols-2 gap-4 mb-10">
                <div class="flex flex-col items-center bg-gray-50 rounded-2xl p-6 hover:-translate-y-1 duration-300">
                    <span class="text-3xl font-black text-emerald-600">{{ $recipesCount }}</span>
                    <span class="text-gray-500 mt-1">رسپی منتشرشده</span>
                </div>
                <div class="flex flex-col items-center bg-gray-50 rounded-2xl p-6 hover:-translate-y-1 duration-300">
                    <span class="text-3xl font-black text-emerald-600">{{ $categoriesCount }}</span>
                    <span class="text-gray-500 mt-1">دسته‌بندی غذایی</span>
                </div>
            </section>

            {{-- چرا ما --}}
            <section aria-labelledby="about-values-title" class="mb-10">
                <h2 id="about-values-title" class="text-2xl font-extrabold text-gray-600 mb-4">چرا Mrchef؟</h2>
                <ul class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <li class="bg-gray-50 rounded-2xl p-5">
                        <h3 class="font-bold mb-2">دستور پخت واضح</h3>
                        <p class="text-gray-600 text-sm">مواد اولیه، مقدار دقیق و مراحل پخت، بدون ابهام.</p>
                    </li>
                    <li class="bg-gray-50 rounded-2xl p-5">
                        <h3 class="font-bold mb-2">امتحان‌شده</h3>
                        <p class="text-gray-600 text-sm">هر رسپی قبل از انتشار حداقل یک بار پخته و تست شده.</p>
                    </li>
                    <li class="bg-gray-50 rounded-2xl p-5">
                        <h3 class="font-bold mb-2">جامعه‌ی آشپزها</h3>
                        <p class="text-gray-600 text-sm">با کامنت زیر هر رسپی، تجربه‌تون رو با بقیه به اشتراک بذارید.</p>
                    </li>
                </ul>
            </section>

            {{-- CTA تماس --}}
            <section aria-label="راه ارتباطی" class="bg-gray-50 rounded-2xl p-8 text-center">
                <h2 class="text-xl font-bold mb-3">سوال یا پیشنهادی دارید؟</h2>
                <p class="text-gray-600 mb-5">خوشحال می‌شیم نظرتون رو بشنویم.</p>
                <a href="{{ route('contact.show') }}"
                    class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl transition">
                    تماس با ما
                </a>
            </section>
        </article>

    </div>

@endsection

@push('schema')
    <x-schema-tag :data="$aboutSchema" />
@endpush