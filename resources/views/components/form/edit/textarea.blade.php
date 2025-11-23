<div>
    <label class="mb-1 font-semibold" id="{{ $btextarea_name }}-label">{{ $btextarea_title }}</label>
    @isset($btextarea_required)
        <span class="text-red-600">*</span>
    @endisset
    <textarea name="{{ $btextarea_name }}" id="{{ $btextarea_name }}" maxlength="160"
        class="w-full border rounded-lg px-3 py-2 mt-1 h-28 focus:outline-none focus:ring focus:border-blue-400 bf-input
        {{ isset($btextarea_required) ? 'bf-is-required' : '' }}
        @if (isset($btextarea_role) && isset($btextarea_role['min-length'])) bf-min-length @endif"
        @if (isset($btextarea_role) && isset($btextarea_role['min-length'])) data-minlength="{{ $btextarea_role['min-length'] }}" @endif
        placeholder="{{ $btextarea_place }}">{{ $btextarea_value ?? null }}</textarea>
    @isset($btextarea_msg)
        <p id="{{ $btextarea_name }}-msg" class="text-gray-500 text-sm">{{ $btextarea_msg }}</p>
    @endisset
    <p id="{{ $btextarea_name }}-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $btextarea_name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
