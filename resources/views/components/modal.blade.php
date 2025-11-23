@props(['id', 'maxWidth' => 'max-w-full'])

<div id="{{ $id }}-overlay"
    class="fixed inset-0 hidden bg-black/50 z-50 overflow-y-auto pt-20 justify-items-center">

    <div id="{{ $id }}"
        class="bg-white rounded-2xl shadow-xl p-6 w-auto min-w-96
                {{ $maxWidth }} mx-4 relative
                transform opacity-0 -translate-y-6 scale-95 transition-all duration-300">

        <button class="absolute top-3 left-4 text-gray-600 hover:text-black"
            onclick="closeModal('{{ $id }}')">✕</button>

        {{ $slot }}
    </div>
</div>
