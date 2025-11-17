<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'this is book shop')">
    <meta name="keywords" content="@yield('meta_keywords', 'book shop')">
    <title>tailwind</title>


    @vite('resources/css/test.css')
</head>

<body>


    <div class="max-w-full h-[400px] my-8
    grid grid-cols-1 sm:grid-cols-1
    mx-4
    md:grid-cols-2
    lg:grid-cols-3
    bg-gray-500">
        <div class="bg-amber-300">1</div>
        <div class="bg-blue-300">2</div>
        <div class="bg-red-300">3</div>
        <div class="bg-gray-300">6</div>
        <div class="bg-green-300">4</div>
    </div>


    <button id="theme-toggle"
        class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-900
        dark:text-gray-100 shadow transition font-semibold">
    </button>

    <div class="max-w-[1400px] mx-auto">
        <div class="flex gap-4 justify-center">
            <div
                class="w-80 border border-gray-200 rounded-2xl overflow-hidden
    shadow pb-2
    dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <img src="{{ asset('files\category\car.webp') }}" alt="" srcset="">
                <div class="p-2 space-y-2">
                    <h2 class="text-xl font-bold">واگذاری پرنده آروم</h2>
                    <p class="text-gray-600">یک پرنده بسیار آروم هستش و دستی هستش و حرف هم میزنه</p>
                    <button class="bg-blue-500 text-white
        rounded py-1 px-3">مشاهده مطلب</button>
                </div>
            </div>
            <div
                class="w-80 border border-gray-200 rounded-2xl overflow-hidden
    shadow pb-2
    dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <img src="{{ asset('files\category\car.webp') }}" alt="" srcset="">
                <div class="p-2 space-y-2">
                    <h2 class="text-xl font-bold">واگذاری پرنده آروم</h2>
                    <p class="text-gray-600">یک پرنده بسیار آروم هستش و دستی هستش و حرف هم میزنه</p>
                    <button class="bg-blue-500 text-white
        rounded py-1 px-3">مشاهده مطلب</button>
                </div>
            </div>
            <div
                class="w-80 border border-gray-200 rounded-2xl overflow-hidden
    shadow pb-2
    dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <img src="{{ asset('files\category\car.webp') }}" alt="" srcset="">
                <div class="p-2 space-y-2">
                    <h2 class="text-xl font-bold">واگذاری پرنده آروم</h2>
                    <p class="text-gray-600">یک پرنده بسیار آروم هستش و دستی هستش و حرف هم میزنه</p>
                    <button class="bg-blue-500 text-white
        rounded py-1 px-3">مشاهده مطلب</button>
                </div>
            </div>
            <div
                class="w-80 border border-gray-200 rounded-2xl overflow-hidden
    shadow pb-2
    dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <img src="{{ asset('files\category\car.webp') }}" alt="" srcset="">
                <div class="p-2 space-y-2">
                    <h2 class="text-xl font-bold">واگذاری پرنده آروم</h2>
                    <p class="text-gray-600">یک پرنده بسیار آروم هستش و دستی هستش و حرف هم میزنه</p>
                    <button class="bg-blue-500 text-white
        rounded py-1 px-3">مشاهده مطلب</button>
                </div>
            </div>

        </div>
    </div>

    <div class="flex mt-16 mx-auto bg-gray-300 w-fit
        rounded overflow-hidden hover:shadow cursor-pointer">
        <img class="w-20" src="{{ asset('files\category\car.webp') }}">
        <div class="flex flex-col p-4">
            <span>babak rostami</span>
            <span>babak@gmail.com</span>
        </div>
    </div>


    @vite('resources/js/test.js')
</body>

</html>
