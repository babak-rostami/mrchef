<a href="{{ $route }}" class="block">
    <div
        class="bg-white shadow border border-gray-50 p-5 rounded-2xl hover:scale-105 duration-300 cursor-pointer flex flex-col items-center gap-2">
        <img src="{{ $icon }}" alt="{{ $title }}">
        <h5 class="font-bold">{{ $title }}</h5>
        <p class="text-gray-500 text-sm">{{ $desc }}</p>
    </div>
</a>
