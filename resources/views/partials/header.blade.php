<header class="bg-gray-900 text-white">
    <nav class="container mx-auto flex items-center justify-between py-4 px-4">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-xl font-semibold flex items-center gap-2">
            <i class="fa-solid fa-code"></i>
            book
        </a>

        <!-- Mobile Button -->
        <button class="md:hidden text-2xl" onclick="document.getElementById('mainNav').classList.toggle('hidden')">
            ☰
        </button>

        <!-- Menu -->
        <ul id="mainNav" class="hidden md:flex flex-col md:flex-row gap-4 mt-4 md:mt-0 text-sm">

            <li>
                <button id="theme-toggle" class="hover:text-indigo-400 cursor-pointer">
                </button>
            </li>

            <li>
                <a href="{{ route('home') }}" class="hover:text-indigo-400">صفحه اصلی</a>
            </li>

            @auth('user')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-400">داشبورد</a>
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="hover:text-red-400">خروج از حساب</button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('login.show') }}" class="hover:text-indigo-400">ورود</a>
                </li>
            @endauth

        </ul>
    </nav>
</header>
