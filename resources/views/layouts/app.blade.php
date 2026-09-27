<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- صفحات ادمین به‌صورت خودکار noindex میشن، بدون اینکه لازم باشه هر ویو دستی تنظیمش کنه.
    اگه یه صفحه‌ی خاص لازم داشت میشه با @section('robots', '...') توی همون ویو override کرد. --}}
    <meta name="robots" content="@yield('robots', request()->is('admin*') ? 'noindex, nofollow' : 'index, follow')">

    <meta name="description"
        content="@yield('meta_description', 'Mrchef؛ رسپی و دستور پخت غذای خانگی، قدم‌به‌قدم و با مواد اولیه مشخص.')">
    <meta name="keywords" content="@yield('meta_keywords', 'رسپی آشپزی, دستور پخت, آموزش آشپزی, غذای خانگی, Mrchef')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="icon" href="{{ config('images.ftp_path') . '/files/icon/chef-icon-36.png' }}">

    {{-- Open Graph / پیش‌نمایش هنگام اشتراک‌گذاری در شبکه‌های اجتماعی --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Mrchef">
    <meta property="og:locale" content="fa_IR">
    <meta property="og:title" content="@yield('title', 'Mrchef')">
    <meta property="og:description"
        content="@yield('meta_description', 'Mrchef؛ رسپی و دستور پخت غذای خانگی، قدم‌به‌قدم و با مواد اولیه مشخص.')">
    <meta property="og:image" content="@yield('og_image', config('images.ftp_path') . '/files/images/behnam.jpg')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <title>@yield('title', 'Mrchef')</title>

    {{-- CSS --}}
    @vite('resources/css/app.css')
    @stack('styles')

    {{-- اسکیمای سراسری سایت، از SchemaComposer میاد (توی همه‌ی صفحات یکسانه) --}}
    <x-schema-tag :data="$organizationSchema" />
    <x-schema-tag :data="$websiteSchema" />
</head>

<body class="text-gray-800">

    <x-partials.header />

    <main>
        <div class="mt-4">
            <div class="px-3 md:p-0 md:mx-8 lg:mx-44">
                <x-partials.alerts />
            </div>
            @yield('content')
        </div>
    </main>

    @include('user.auth-modal.index')

    <x-partials.main-search />

    <x-mobile.bottom-nav />

    <x-partials.footer />

    <script>
        window.isGuest = @json(auth()->guest());
    </script>

    @vite('resources/js/app.js')
    @stack('scripts')

    {{-- اسکیمای اختصاصی هر صفحه (Recipe، BreadcrumbList، ContactPage و ...)، از کنترلر یا کامپوننت میاد --}}
    @stack('schema')
</body>

</html>