<header class="px-3 md:p-0 md:mx-8 lg:mx-44 mt-2">
    <nav class="container mx-auto flex items-center justify-between py-4 px-4 bg-gray-50 shadow-sm rounded-2xl"
        aria-label="منوی اصلی">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-xl font-semibold flex items-center gap-2 hover:scale-105 transition"
            aria-label="Mrchef، بازگشت به صفحه اصلی">
            <img src="{{ config('images.ftp_path') . '/files/icon/chef-icon-36.png' }}" alt="لوگوی Mrchef" width="36"
                height="36">
            <span class="text-gray-900">Mrchef</span>
        </a>

        {{-- Center Menu --}}
        <ul class="hidden md:flex items-center gap-6 text-sm font-medium">

            <li>
                <a href="{{ route('recipes.index') }}" class="text-gray-600 hover:text-emerald-600 transition">
                    رسپی‌ها
                </a>
            </li>

            <li>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-emerald-600 transition">
                    درباره ما
                </a>
            </li>

            <li>
                <a href="{{ route('contact.show') }}" class="text-gray-600 hover:text-emerald-600 transition">
                    تماس با ما
                </a>
            </li>

            <li>
                <button onclick="openModal('main-search')" type="button"
                    class="flex items-center gap-1 text-gray-600 hover:text-emerald-600 transition cursor-pointer">
                    جستجو
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m1.85-5.4a7.25 7.25 0 11-14.5 0 7.25 7.25 0 0114.5 0z" />
                    </svg>
                </button>
            </li>

        </ul>

        {{-- Profile --}}
        <div class="relative">

            {{-- Avatar --}}
            <button id="profile-toggle" type="button" aria-haspopup="true" aria-expanded="false"
                aria-controls="profile-dropdown" aria-label="منوی حساب کاربری" class="w-10 h-10 rounded-full overflow-hidden
                       hover:scale-105
                       transition flex items-center justify-center bg-white cursor-pointer">

                @auth('user')
                    <img src="{{ auth('user')->user()->thumb_url ?? config('images.ftp_path') . '/files/icon/profile2-40.png' }}"
                        alt="عکس پروفایل {{ auth('user')->user()->name }}" class="w-full h-full object-cover">
                @else
                    {{-- id="login-btn" رو اضافه کردم؛ menu.js از قبل دنبال همین آیدی می‌گشت
                    تا قبل از باز کردن مودال ورود، دراپ‌داون رو ببنده --}}
                    <svg id="login-btn" onclick="openModal('user-login')" class="w-6 h-6 text-emerald-600" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                @endauth
            </button>

            {{-- Dropdown --}}
            <div id="profile-dropdown" class="hidden absolute left-0 mt-3 w-44
                        bg-white rounded-xl shadow-lg border border-gray-200 p-2 text-sm z-10" role="menu">

                @auth('user')
                    <div class="px-3 py-2 text-gray-600">
                        {{ auth('user')->user()->name }}
                    </div>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="w-full text-right px-3 py-2 rounded-lg
                                               text-red-500 hover:bg-red-50 transition cursor-pointer">
                            خروج از حساب
                        </button>
                    </form>
                @endauth

            </div>
        </div>

    </nav>
</header>