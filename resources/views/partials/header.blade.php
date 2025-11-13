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
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">صفحه اصلی</a></li>
                    <li class="nav-item"><a href="{{ url('/about') }}" class="nav-link">درباره ما</a></li>
                    <li class="nav-item"><a href="{{ url('/contact') }}" class="nav-link">تماس با ما</a></li>
                    <li class="nav-item"><a href="{{ url('/blog') }}" class="nav-link">بلاگ</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
