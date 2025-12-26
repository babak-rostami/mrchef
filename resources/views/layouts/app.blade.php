<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'this is book shop')">
    <meta name="keywords" content="@yield('meta_keywords', 'book shop')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'book')</title>

    {{-- CSS --}}
    @hasSection('styles')
        @yield('styles')
    @else
        @vite(['resources/css/app.css'])
    @endif
</head>

<body class="text-gray-800">

    <x-partials.header />

    <div class="mt-4">
        <div class="md:mx-8 lg:mx-44">
            <x-partials.alerts />
        </div>
        @yield('content')
    </div>

    @include('user.auth-modal.index')

    <x-partials.main-search />

    <x-mobile.bottom-nav />

    <x-partials.footer />

    <script>
        window.isGuest = @json(auth()->guest());
    </script>

    @hasSection('scripts')
        @yield('scripts')
    @else
        @vite(['resources/js/app.js'])
    @endif
</body>

</html>
