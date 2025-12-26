<nav
    class="fixed bottom-1 left-3 right-3 z-50
           md:hidden
           bg-white/90 backdrop-blur
           rounded-2xl shadow-xl border border-gray-300
           flex justify-between items-center
           px-4 h-16">

    {{-- خانه --}}
    <a href="{{ url('/') }}"
        class="group flex flex-col items-center gap-1 w-full transition
              {{ request()->is('/') ? 'text-emerald-600' : 'text-gray-400' }}">
        <svg class="w-6 h-6 transition-transform group-active:scale-90" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 9.75L12 3l9 6.75V21a.75.75 0 01-.75.75H3.75A.75.75 0 013 21V9.75z" />
        </svg>
        <span class="text-xs font-medium">خانه</span>
    </a>

    {{-- رسپی --}}
    <a href="{{ url('/recipes') }}"
        class="group flex flex-col items-center gap-1 w-full transition
              {{ request()->is('recipes*') || request()->is('recipe*') ? 'text-emerald-600' : 'text-gray-400' }}">
        <svg class="w-6 h-6 transition-transform group-active:scale-90" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13a4 4 0 110-8 4 4 0 010 8z" />
        </svg>
        <span class="text-xs font-medium">رسپی</span>
    </a>

    {{-- جستجو --}}
    <button onclick="openModal('main-search')"
        class="group flex flex-col items-center gap-1 w-full text-gray-400 transition">
        <div
            class="bg-emerald-500 text-white p-3 rounded-full shadow-lg
                   -mt-2 active:scale-95 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m1.85-5.4a7.25 7.25 0 11-14.5 0 7.25 7.25 0 0114.5 0z" />
            </svg>
        </div>
    </button>

    {{-- پروفایل --}}
    <button onclick="openProfileModal()"
        class="group flex flex-col items-center gap-1 w-full transition
               {{ request()->is('profile*') ? 'text-emerald-600' : 'text-gray-400' }}">
        <svg class="w-6 h-6 transition-transform group-active:scale-90" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="text-xs font-medium">پروفایل</span>
    </button>

</nav>
