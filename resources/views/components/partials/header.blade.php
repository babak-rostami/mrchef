<header class="bg-gray-50 md:mx-8 lg:mx-44 rounded-2xl mt-2">
    <nav class="container mx-auto flex items-center justify-between py-4 px-4">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-xl font-semibold flex items-center gap-2 duration-200 hover:scale-105">
            <img src="{{ asset('files/icon/chef-icon-36.png') }}" alt="mr chef">
            Mrchef
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

            @auth('user')
                @role('admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-400">داشبورد</a>
                    </li>
                @endrole
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="hover:text-red-400 cursor-pointer">خروج از حساب</button>
                    </form>
                </li>
            @else
                <li>
                    <span onclick="openModal('user-login')" class="hover:text-indigo-400 cursor-pointer">ورود</span>
                </li>
            @endauth

        </ul>
    </nav>
</header>
