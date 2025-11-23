<div>
    <label class="font-semibold" id="bf-main-image-label">
        {{ $bimage_title }}
        @isset($bimage_required)
            <span class="text-red-600">*</span>
        @endisset
    </label>

    <input type="file" name="{{ $bimage_name }}" id="bf-main-image" accept="{{ $bimage_accept ?? 'image/*' }}"
        class="hidden bf-input {{ isset($bimage_required) ? 'bf-is-required' : '' }}">

    <div id="bf-image-picker"
        class="relative w-full h-48 border-2 mt-2 border-dashed border-gray-300 rounded-lg 
                flex flex-col items-center justify-center cursor-pointer
                hover:bg-gray-50 transition">

        <img id="bf-main-image-show" class="hidden h-full rounded-lg" />

        <div id="bf-image-placeholder" class="flex flex-col items-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 7h18M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2M3 7v12a2 2 0 002 2h14a2 2 0 002-2V7M8 14l2 2 4-4 4 4" />
            </svg>
            <p>برای انتخاب عکس کلیک کنید</p>
        </div>

        <!-- دکمه hover برای ویرایش عکس -->
        <div id="bf-image-overlay"
            class="absolute inset-0 bg-black/20 text-white text-2xl font-bold 
                    flex items-center justify-center hidden
                    transition-opacity duration-200 pointer-events-none">
            تغییر عکس
        </div>
    </div>

    <p id="bf-main-image-msg" class="text-gray-500 text-sm">{{ $bimage_msg }}</p>
    <p id="bf-main-image-error" class="text-red-500 text-sm hidden bf-error-msg"></p>

    @error('{{ $bimage_name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
