<nav class="mb-6">
    <ol class="flex items-center gap-2 text-sm text-gray-600">

        <li>
            <a href="{{ route('dashboard') }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                <i class="fa-solid fa-home ml-1"></i>
                داشبورد
            </a>
        </li>

        @isset($breadcrumb_parents)
            @foreach ($breadcrumb_parents as $breadcrumb_parent)
                <li class="text-gray-400">/</li>
                <li>
                    <a href="{{ $breadcrumb_parent['url'] }}"
                        class="flex items-center text-indigo-600  hover:text-indigo-800">
                        {{ $breadcrumb_parent['title'] }}
                    </a>
                </li>
            @endforeach
        @endisset


        <li class="text-gray-400">/</li>

        <li class="text-gray-800 font-semibold">
            {{ $breadcrumb_title }}
        </li>

    </ol>
</nav>
