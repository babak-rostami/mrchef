<div>
    <label class="mb-1 font-semibold">{{ $binput_title }}</label>
    <input type="text" readonly
        class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-200 focus:outline-none"
        value="{{ $binput_value ?? null }}">
    @isset($binput_msg)
        <p id="{{ $binput_name }}-msg" class="text-gray-500 text-sm">{{ $binput_msg }}</p>
    @endisset
</div>
