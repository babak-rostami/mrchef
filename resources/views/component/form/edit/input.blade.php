<div>
    <label class="mb-1 font-semibold" id="{{ $binput_name }}-label">{{ $binput_title }}
        @isset($bf_is_required)
            <span class="text-red-600">*</span>
        @endisset
    </label>
    <input type="text" name="{{ $binput_name }}"
        @if (isset($binput_role) && isset($binput_role['max-length'])) maxlength="{{ $binput_role['max-length'] }}" @endif
        @if (isset($binput_role) && isset($binput_role['min-length'])) data-minlength="{{ $binput_role['min-length'] }}" @endif
        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400
        {{ isset($bf_is_required) ? 'bf-is-required' : '' }}
        @if (isset($binput_role) && isset($binput_role['slug'])) bf-input-slug @endif
        @if (isset($binput_role) && isset($binput_role['min-length'])) bf-min-length @endif bf-input"
        id="{{ $binput_name }}" placeholder="{{ $binput_place }}" value="{{ $binput_value ?? null }}">
    @isset($binput_msg)
        <p id="{{ $binput_name }}-msg" class="text-gray-500 text-sm">{{ $binput_msg }}</p>
    @endisset
    <p id="{{ $binput_name }}-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $binput_name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
