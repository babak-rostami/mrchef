@props(['title', 'id', 'msg' => null, 'value' => null])


<div>
    <label class="mb-1 font-semibold">{{ $title }}</label>
    <input type="text" readonly class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-200 focus:outline-none"
        value="{{ $value ?? null }}">
    @isset($msg)
        <p id="{{ $id }}-msg" class="text-gray-500 text-sm">{{ $msg }}</p>
    @endisset
</div>
