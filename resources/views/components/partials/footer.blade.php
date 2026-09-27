<footer class="bg-gray-50 rounded-2xl mt-10 md:mx-8 lg:mx-44 mb-14 md:mb-0">
    <div class="container mx-auto py-8 text-center">

        <nav aria-label="لینک‌های فوتر" class="mb-4">
            <ul class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-emerald-600">خانه</a></li>
                <li><a href="{{ route('recipes.index') }}" class="hover:text-emerald-600">رسپی‌ها</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-emerald-600">درباره ما</a></li>
                <li><a href="{{ route('contact.show') }}" class="hover:text-emerald-600">تماس با ما</a></li>
            </ul>
        </nav>

        <ul class="flex justify-center gap-4 text-xl mt-2" aria-label="شبکه‌های اجتماعی">
            <li>
                <a href="https://www.instagram.com/mrchef.iran/" target="_blank" rel="noopener"
                    class="hover:text-indigo-300" aria-label="اینستاگرام Mrchef">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/@behnamrostami" target="_blank" rel="noopener"
                    class="hover:text-indigo-300" aria-label="یوتیوب Mrchef">
                    <i class="fab fa-youtube" aria-hidden="true"></i>
                </a>
            </li>
        </ul>

        <p class="mb-1 mt-4 text-sm text-gray-500">© {{ date('Y') }} Mrchef، تمامی حقوق محفوظ است.</p>
    </div>
</footer>