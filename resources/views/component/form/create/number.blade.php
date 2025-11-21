<div>
    <label class="mb-1 font-semibold" id="{{ $bnumber_name }}-label">{{ $bnumber_title }}
    </label>
    @isset($bf_is_required)
        <span class="text-red-600">*</span>
    @endisset
    <input type="text" name="{{ $bnumber_name }}"
        @if (isset($bnumber_role) && isset($bnumber_role['max-number'])) data-maxnumber="{{ $bnumber_role['max-number'] }}" @endif
        @if (isset($bnumber_role) && isset($bnumber_role['min-number'])) data-minnumber="{{ $bnumber_role['min-number'] }}" @endif
        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400
        {{ isset($bf_is_required) ? 'bf-is-required'  : '' }} bf-number-input bf-input"
        id="{{ $bnumber_name }}" placeholder="{{ $bnumber_place }}" value="{{ old($bnumber_name) }}">
    @isset($bnumber_msg)
        <p id="{{ $bnumber_name }}-msg" class="text-gray-500 text-sm">{{ $bnumber_msg }}</p>
    @endisset
    <p id="{{ $bnumber_name }}-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $bnumber_name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
