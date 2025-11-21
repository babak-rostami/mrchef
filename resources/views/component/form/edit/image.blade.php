<div>
    <label class="mb-1 font-semibold" id="{{ $bimage_name }}-label">{{ $bimage_title }}
        @isset($bimage_required)
            <span class="text-red-600">*</span>
        @endisset
    </label>
    <input type="file" name="{{ $bimage_name }}" id="bf-main-image" accept="{{ $bimage_accept ?? 'image/*' }}"
        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400 bf-input
        {{ isset($bimage_required) ? 'bf-is-required' : '' }}">
    <p id="{{ $bimage_name }}-msg" class="text-gray-500 text-sm">{{ $bimage_msg }}</p>
    <p id="{{ $bimage_name }}-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $bimage_name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
