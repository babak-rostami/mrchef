@props(['panel' => 'user', 'page' => null, 'parents' => []])

<nav class="mb-6">
    <ol class="flex items-center gap-2 text-sm text-gray-600">

        <li>
            @if ($panel == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                    <i class="fa-solid fa-home ml-1"></i>
                    داشبورد
                </a>
            @elseif($panel == 'user')
                <a href="{{ route('home') }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                    <i class="fa-solid fa-home ml-1"></i>
                    خانه
                </a>
            @endif
        </li>

        @foreach ($parents as $parent)
            <li class="text-gray-400">/</li>
            <li>
                <a href="{{ $parent['url'] }}" class="flex items-center text-indigo-600  hover:text-indigo-800">
                    {{ $parent['title'] }}
                </a>
            </li>
        @endforeach


        <li class="text-gray-400">/</li>

        <li class="text-gray-800 font-semibold">
            {{ $page }}
        </li>

    </ol>
</nav>
