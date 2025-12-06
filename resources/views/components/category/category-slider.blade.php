{{-- for use this slider --}}
{{-- @import "../../bslider/index.css"; --}}
{{-- import '../../component/bslider/index' --}}

@props(['categories' => [], 'route'])

@if ($route)
    <div class="bslider pb-4" id="category-slider">
        @foreach ($categories as $category)
            <div
                class="bslider-item category-slider-item cursor-pointer rounded-2xl ml-8 bg-white py-3
            hover:-translate-y-4 transition-all duration-300 ease-out">
                <a href="{{ route($route, $category->slug) }}">
                    <div class="flex flex-col items-center">
                        <img class="w-24 h-24 object-contain" src="{{ $category->image_url }}" alt="{{ $category->name }}">
                        <span class="font-bold mt-4 text-gray-500">{{ $category->name }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif
