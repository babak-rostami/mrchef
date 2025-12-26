{{-- <button onclick="openModal('modal-id')">
</button>
<x-modal id="modal-id">
</x-modal> --}}

@props(['id', 'bg' => null, 'width' => null])

<div id="{{ $id }}-overlay"
    class="fixed inset-0 hidden bg-black/80 z-50 overflow-y-auto pt-20 justify-items-center">

    <div id="{{ $id }}"
        class="relative bg-white rounded-2xl shadow-lg shadow-gray-900 p-6 {{ $width ? $width : 'w-auto' }} md:min-w-[450px]
               max-w-full mx-4 overflow-hidden
               transform opacity-0 -translate-y-6 scale-95
               transition-all duration-300">

        {{-- background image --}}
        @if ($bg)
            <div class="absolute inset-0 bg-cover bg-center blur-[2px]"
                style="background-image: url('{{ $bg }}')"></div>

            {{-- background overlay --}}
            <div class="absolute inset-0 bg-black/50"></div>
        @endif

        {{-- close button --}}
        <button class="absolute top-3 left-4 z-20 text-gray-600
        hover:text-black cursor-pointer"
            onclick="closeModal('{{ $id }}')">
            ✕
        </button>

        {{-- modal content --}}
        <div class="relative z-10">
            {{ $slot }}
        </div>

    </div>
</div>
