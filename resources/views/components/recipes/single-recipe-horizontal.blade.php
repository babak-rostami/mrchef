@props(['recipe'])

@if ($recipe)
    <div
        class="grid grid-cols-1 md:grid-cols-[auto_1fr] mt-4 rounded-2xl overflow-hidden items-start
    border border-gray-100">

        <!-- IMAGE -->
        <div class="flex justify-center md:block">
            <img class="w-11/12 md:w-auto md:h-64 object-contain rounded-2xl md:rounded-none"
                src="{{ $recipe->image_url }}" alt="pizza">
        </div>

        <!-- TEXT BOX -->
        <div
            class="flex flex-col items-start p-4 gap-4
            rounded-2xl md:rounded-none
            mt-4 md:mt-0 md:h-full w-full">
            <span class="text-3xl font-extrabold text-gray-600">{{ $recipe->title }}</span>

            <span class="whitespace-pre-line">{{ $recipe->description }}</span>

            <a href="/recipes"
                class="group flex items-center gap-2 bg-white text-green-700
            px-4 py-2 rounded-3xl hover:bg-green-800 hover:text-white">
                <span>دستور پخت</span>
                <img class="bg-green-900 rounded-2xl p-1" src="{{ asset('files/icon/arrow-left-24.png') }}"
                    alt="arrow">
            </a>
        </div>
    </div>
@endif
