<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fa-solid fa-code"></i> book
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="mainNav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">صفحه اصلی</a></li>
                    @auth('user')
                        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">داشبورد</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="nav-link" type="submit">خروج از حساب</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a href="{{ route('login.show') }}" class="nav-link">ورود</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
