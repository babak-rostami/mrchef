<div>
    <div class="mb-2">
        <label class="font-semibold" id="{{ $bckeditor_name }}-label">{{ $bckeditor_title }}
        </label>
        @isset($bckeditor_required)
            <span class="text-red-600">*</span>
        @endisset
    </div>
    <textarea id="{{ $bckeditor_name }}" name="{{ $bckeditor_name }}"
        class="w-full mt-1 border rounded-lg px-3 py-2 bf-ckeditor
    {{ isset($bckeditor_required) ? 'bckeditor_required' : '' }} bf-input"
        placeholder="{{ $bckeditor_place }}"></textarea>
    @isset($bckeditor_msg)
        <p id="{{ $bckeditor_name }}-msg" class="text-gray-500 text-sm">{{ $bckeditor_msg }}</p>
    @endisset
    <p id="{{ $bckeditor_name }}-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $bckeditor_name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
