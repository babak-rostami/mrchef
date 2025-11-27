@props(['title', 'name', 'id', 'required' => false, 'accept' => 'image/*', 'msg' => null])

<div>
    <label class="font-semibold" id="{{ $id }}-bf-label">
        {{ $title }}
        @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
 
    {{-- input اصلی --}}
    <input type="file" name="{{ $name }}" id="{{ $id }}" accept="{{ $accept }}"
        class="hidden bf-input {{ $required ? 'bf-is-required' : '' }}">

    <div id="{{ $id }}-bf-img-picker"
        class="relative w-full h-48 border-2 mt-2 border-dashed border-gray-300 rounded-lg
               flex flex-col items-center justify-center cursor-pointer
               hover:bg-gray-50 transition">

        {{-- عکس --}}
        <img id="{{ $id }}-bf-img-show" class="hidden h-full rounded-lg" />

        {{-- placeholder --}}
        <div id="{{ $id }}-bf-img-place" class="flex flex-col items-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 7h18M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2M3 7v12a2 2 0 002 2h14a2 2 0 002-2V7M8 14l2 2 4-4 4 4" />
            </svg>
            <p>برای انتخاب عکس کلیک کنید</p>
        </div>

        {{-- overlay روی عکس هنگام hover --}}
        <div id="{{ $id }}-bf-img-over"
            class="absolute inset-0 bg-black/20 text-white text-xl font-semibold
                   flex items-center justify-center hidden pointer-events-none
                   transition-opacity duration-200">
            تغییر عکس
        </div>
    </div>

    {{-- پیام --}}
    @if ($msg)
        <p id="{{ $id }}-bf-msg" class="text-gray-500 text-sm mt-1">{{ $msg }}</p>
    @endif
    {{-- خطای js --}}
    <p id="{{ $id }}-bf-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    {{-- خطای سرور --}}
    @error($name)
        <p class="text-danger text-sm">{{ $message }}</p>
    @enderror

</div>
