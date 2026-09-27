@extends('layouts.app')

@section('title', 'تماس با ما')
@section('meta_description', 'سوال، پیشنهاد یا انتقادی دارید؟ از طریق فرم تماس با تیم Mrchef در ارتباط باشید.')
@section('meta_keywords', 'تماس با ما')

@section('content')

    <x-partials.breadcrumb panel="user" page="تماس با ما" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-16">

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

            {{-- اطلاعات تماس --}}
            <section aria-labelledby="contact-info-title" class="md:col-span-2">
                <h1 id="contact-info-title" class="text-3xl font-black text-gray-700 mb-3">تماس با ما</h1>
                <p class="text-gray-600 leading-loose mb-6">
                    برای سوال، پیشنهاد یا گزارش مشکل، فرم کنار رو پر کنید یا از راه‌های زیر باهامون در ارتباط باشید.
                </p>

                {{-- address تگ معنایی درست HTML5 برای اطلاعات تماسه --}}
                <address class="not-italic bg-gray-50 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <i class="fa fa-envelope text-emerald-600" aria-hidden="true"></i>
                        {{-- TODO: ایمیل واقعی رو جایگزین کنید --}}
                        <a href="mailto:info@example.com" class="hover:text-emerald-700">info@example.com</a>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fab fa-instagram text-emerald-600" aria-hidden="true"></i>
                        <a href="https://www.instagram.com/mrchef.iran/" target="_blank" rel="noopener"
                            class="hover:text-emerald-700">instagram.com/mrchef.iran</a>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fab fa-youtube text-emerald-600" aria-hidden="true"></i>
                        <a href="https://www.youtube.com/@behnamrostami" target="_blank" rel="noopener"
                            class="hover:text-emerald-700">youtube.com/@behnamrostami</a>
                    </div>
                </address>
            </section>

            {{-- فرم تماس --}}
            <section aria-labelledby="contact-form-title" class="md:col-span-3">
                <h2 id="contact-form-title" class="sr-only">فرم ارسال پیام</h2>

                <form id="contact-store-form" action="{{ route('contact.store') }}" method="POST"
                    class="w-full space-y-6 bg-gray-50 rounded-2xl p-6">
                    @csrf

                    {{-- هانی‌پات ضد اسپم: برای کاربر واقعی نامرئیه، ولی ربات‌های فرم‌پرکن معمولاً پرش می‌کنن.
                    اگه پر بشه، سمت سرور (StoreRequest) ولیدیشن رد میشه. --}}
                    <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
                        <label for="website">لطفاً این فیلد را خالی بگذارید</label>
                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                    </div>

                    {{-- NAME --}}
                    <x-form.create.input name="name" id="name" title="نام شما" placeholder="مثال: علی محمدی"
                        :required="true" msg="حداقل 3 کاراکتر" :roles="['min-len' => 3, 'max-len' => 60]" />

                    {{-- BODY --}}
                    <x-form.create.textarea name="body" id="body" title="متن پیام"
                        placeholder="سوال، پیشنهاد یا انتقادتون رو اینجا بنویسید..." :required="true" msg="حداقل 10 کاراکتر"
                        :roles="['min-len' => 10, 'max-len' => 2000]" />

                    {{-- SUBMIT --}}
                    <x-form.create.submit title="ارسال پیام" />
                </form>
            </section>

        </div>

    </div>

@endsection

@push('scripts')
    @vite(['resources/js/contact/create.js'])
@endpush

@push('schema')
    <x-schema-tag :data="$contactSchema" />
@endpush