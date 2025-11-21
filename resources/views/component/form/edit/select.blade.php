<div>
    <label class="mb-1 font-semibold" id="{{ $bselect_name }}-label">{{ $bselect_title }}
    </label>
    @isset($bselect_required)
        <span class="text-red-600">*</span>
    @endisset
    <select name="{{ $bselect_name }}" id="{{ $bselect_name }}"
        class="{{ isset($bselect_required) ? 'bf-is-required' : '' }} w-full border rounded-lg bf-input
        px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
        @isset($bselect_default_option)
            <option value="">{{ $bselect_default_option }}</option>
        @endisset
        @if (isset($bselect_items))
            @foreach ($bselect_items as $bselect_item)
                <option value="{{ $bselect_item->id }}"
                    {{ isset($bselect_value) && $bselect_value == $bselect_item->id ? 'selected' : '' }}>
                    {{ $bselect_item->$bselect_items_name }}
                </option>
            @endforeach
        @elseif(isset($bselect_array_items))
            @foreach ($bselect_array_items as $key => $bselect_item)
                <option value="{{ $key }}"
                    {{ isset($bselect_value) && $bselect_value == $key ? 'selected' : '' }}>
                    {{ $bselect_item }}
                </option>
            @endforeach
        @endif
    </select>
    <p id="{{ $bselect_name }}-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error("{{ $bselect_name }}")
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
