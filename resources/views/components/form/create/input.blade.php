@props(['name', 'id', 'title', 'placeholder' => '', 'msg' => null, 'required' => false, 'roles' => []])

<div>
    <label for="{{ $id }}" id="{{ $id }}-bf-label" class="mb-1 font-semibold">
        {{ $title }}
        @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>

    <input type="text" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}"
        value="{{ old($id) }}" @isset($roles['max-len']) maxlength="{{ $roles['max-len'] }}" @endisset
        @isset($roles['min-len']) data-minlength="{{ $roles['min-len'] }}" @endisset
        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400
        bf-input-text
        {{ $required ? 'bf-is-required' : '' }}
        @isset($roles['slug'])) bf-input-slug @endisset
        @isset($roles['min-len']) bf-min-length @endisset
        bf-input" />

    @isset($msg)
        <p id="{{ $id }}-bf-msg" class="text-gray-500 text-sm">{{ $msg }}</p>
    @endisset
    <p id="{{ $id }}-bf-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
