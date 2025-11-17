<nav class="mb-6">
    <ol class="flex items-center gap-2 text-sm text-gray-600">

        <li>
            <a href="{{ route('dashboard') }}" class="flex items-center hover:underline text-indigo-600">
                <i class="fa-solid fa-home ml-1"></i>
                داشبورد
            </a>
        </li>

        <li class="text-gray-400">/</li>

        <li class="text-gray-800 font-semibold">
            {{ $breadcrumb_title }}
        </li>

    </ol>
</nav>
