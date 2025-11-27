@props(['title', 'name', 'id', 'placeholder' => null, 'msg' => null, 'required' => false])

<div>
    <div class="mb-2">
        <label for="{{ $id }}" id="{{ $id }}-bf-label" class="font-semibold">
            {{ $title }}
            @if ($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    </div>

    <textarea id="{{ $id }}" name="{{ $name }}"
        class="w-full mt-1 border rounded-lg px-3 py-2 bf-textarea bf-input {{ $required ? 'bf-ckeditor-required' : '' }}"
        placeholder="{{ $placeholder }}">{{ old($name) }}</textarea>

    @isset($msg)
        <p id="{{ $id }}-bf-msg" class="text-gray-500 text-sm">{{ $msg }}</p>
    @endisset
    <p id="{{ $id }}-bf-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
