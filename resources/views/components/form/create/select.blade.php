@props([
    'title',
    'name',
    'id',
    'msg' => null,
    'items' => null, // if collection
    'itemsName' => null, // if collection => field name
    'arrayItems' => null, // if array => simple array
    'default' => null, // default option text
    'required' => false,
])
 
<div>
    <label for="{{ $name }}" id="{{ $id }}-bf-label" class="mb-1 font-semibold">
        {{ $title }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <select name="{{ $name }}" id="{{ $name }}"
        class="bf-input bf-select w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-primary
        {{ $required ? 'bf-is-required' : '' }}">
        {{-- default option --}}
        @if ($default)
            <option value="">{{ $default }}</option>
        @endif

        {{-- اگر کالکشن داده شده باشد --}}
        @if ($items && $itemsName)
            @foreach ($items as $item)
                <option value="{{ $item->id }}" {{ old($name) == $item->id ? 'selected' : '' }}>
                    {{ $item->$itemsName }}
                </option>
            @endforeach
        @endif

        {{-- اگر آرایه داده شده باشد --}}
        @if ($arrayItems)
            @foreach ($arrayItems as $item)
                <option value="{{ $item['value'] }}" {{ old($name) == $item['value'] ? 'selected' : '' }}>
                    {{ $item['label'] }}
                </option>
            @endforeach
        @endif

    </select>

    @isset($msg)
        <p id="{{ $id }}-bf-msg" class="text-gray-500 text-sm">{{ $msg }}</p>
    @endisset
    <p id="{{ $id }}-bf-error" class="text-red-500 text-sm hidden bf-error-msg"></p>
    @error('{{ $name }}')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>
