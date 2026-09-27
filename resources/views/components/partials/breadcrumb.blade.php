@props(['panel' => 'user', 'page' => null, 'parents' => []])

<nav class="mb-6 px-3 md:p-0 md:mx-8 lg:mx-44" aria-label="مسیر صفحه">
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1.5 text-sm text-gray-600 leading-relaxed">

        <li>
            @if ($panel == 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center text-gray-400 hover:text-indigo-800 hover:translate-x-0.5 duration-300">
                    <i class="fa-solid fa-home ml-1" aria-hidden="true"></i>
                    داشبورد
                </a>
            @elseif($panel == 'user')
                <a href="{{ route('home') }}"
                    class="flex items-center text-gray-400 hover:text-indigo-800 hover:translate-x-0.5 duration-300">
                    <i class="fa-solid fa-home ml-1" aria-hidden="true"></i>
                    خانه
                </a>
            @endif
        </li>

        @foreach ($parents as $parent)
            <li class="text-gray-400" aria-hidden="true">/</li>
            <li>
                <a href="{{ $parent['url'] }}"
                    class="flex items-center text-gray-400  hover:text-indigo-800 hover:translate-x-0.5 duration-300">
                    {{ $parent['title'] }}
                </a>
            </li>
        @endforeach


        <li class="text-gray-400" aria-hidden="true">/</li>

        <li class="text-gray-800 font-semibold hover:translate-x-0.5 duration-300" aria-current="page">
            {{ $page }}
        </li>

    </ol>
</nav>

@if (!empty($breadcrumbSchema))
    @push('schema')
        <x-schema-tag :data="$breadcrumbSchema" />
    @endpush
@endif