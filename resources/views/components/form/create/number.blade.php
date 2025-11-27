@props(['name', 'id', 'title', 'placeholder' => '', 'msg' => null, 'required' => false, 'roles' => []])

<div>
    <label for="{{ $id }}" id="{{ $id }}-bf-label" class="mb-1 font-semibold">
        {{ $title }}
        @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>

    <input type="text" id="{{ $id }}" name="{{ $name }}"
        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-primary bf-number-input bf-input
        {{ $required ? 'bf-is-required' : '' }}"
        placeholder="{{ $placeholder }}" value="{{ old($name) }}"
        @isset($roles['min-number']) data-minnumber="{{ $roles['min-number'] }}" @endisset
        @isset($roles['max-number']) data-maxnumber="{{ $roles['max-number'] }}" @endisset>

    @isset($msg)
        <p id="{{ $id }}-bf-msg" class="text-gray-500 text-sm">{{ $msg }}</p>
    @endisset
    <p id="{{ $id }}-bf-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
