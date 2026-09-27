<a href="{{ $route }}" class="block relative">
    @if (!empty($badge))
        <span class="absolute -top-2 -left-2 bg-red-500 text-white text-xs font-bold
                w-6 h-6 rounded-full flex items-center justify-center shadow" aria-label="{{ $badge }} پیام جدید">
            {{ $badge }}
        </span>
    @endif
    <div
        class="bg-white shadow border border-gray-50 p-5 rounded-2xl hover:scale-105 duration-300 cursor-pointer flex flex-col items-center gap-2">
        @if (!empty($icon))
            <img src="{{ $icon }}" alt="{{ $title }}">
        @elseif (!empty($icon_class))
            <i class="{{ $icon_class }} text-3xl text-emerald-600" aria-hidden="true"></i>
        @endif
        <h2 class="font-bold">{{ $title }}</h2>
        <p class="text-gray-500 text-sm">{{ $desc }}</p>
    </div>
</a>