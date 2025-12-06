<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'this is book shop')">
    <meta name="keywords" content="@yield('meta_keywords', 'book shop')">
    <title>@yield('title', 'book')</title>

    @stack('styles')
</head>

<body class="text-gray-800">

    <x-partials.header />

    <div class="px-4 mt-4">
        <x-partials.alerts />
        @yield('content')
    </div>

    <x-partials.footer />

    @stack('scripts')
</body>

</html>
