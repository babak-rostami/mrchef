<header class="bg-gray-50 md:mx-8 lg:mx-44 rounded-2xl mt-2 shadow-sm">
    <nav class="container mx-auto flex items-center justify-between py-4 px-4">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-xl font-semibold flex items-center gap-2 hover:scale-105 transition">
            <img src="{{ asset('files/icon/chef-icon-36.png') }}" alt="mr chef">
            <span class="text-gray-900">Mrchef</span>
        </a>

        {{-- Center Menu --}}
        <ul class="hidden md:flex items-center gap-6 text-sm font-medium">

            <li>
                <a href="{{ url('/recipes') }}" class="text-gray-600 hover:text-emerald-600 transition">
                    رسپی‌ها
                </a>
            </li>

            <li>
                <button id="search-btn"
                    class="flex items-center gap-1 text-gray-600 hover:text-emerald-600 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m1.85-5.4a7.25 7.25 0 11-14.5 0 7.25 7.25 0 0114.5 0z" />
                    </svg>
                    جستجو
                </button>
            </li>

        </ul>

        {{-- Profile --}}
        <div class="relative">

            {{-- Avatar --}}
            <button id="profile-toggle"
                class="w-10 h-10 rounded-full overflow-hidden
                       hover:scale-105
                       transition flex items-center justify-center bg-white cursor-pointer">

                @auth('user')
                    <img src="{{ auth('user')->user()->thumb_url ?? asset('files/icon/profile2-40.png') }}"
                        class="w-full h-full object-cover">
                @else
                    <svg onclick="openModal('user-login')" class="w-6 h-6 text-emerald-600" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                @endauth
            </button>

            {{-- Dropdown --}}
            <div id="profile-dropdown"
                class="hidden absolute left-0 mt-3 w-44
                        bg-white rounded-xl shadow-lg border border-gray-200 p-2 text-sm z-10">

                @auth('user')
                    <div class="px-3 py-2 text-gray-600">
                        {{ auth('user')->user()->name }}
                    </div>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button
                            class="w-full text-right px-3 py-2 rounded-lg
                                   text-red-500 hover:bg-red-50 transition cursor-pointer">
                            خروج از حساب
                        </button>
                    </form>
                @endauth

            </div>
        </div>

    </nav>
</header>
