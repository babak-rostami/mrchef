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

<body class="bg-gray-50 text-gray-800">

    @include('partials.header')

    <main class="mx-auto px-4 my-6">
        @include('partials.alerts')
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>

</html>
