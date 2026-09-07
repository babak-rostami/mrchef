<div class="text-center hidden" id="auth-register-section">
    <span class="text-2xl font-bold text-white block mb-2 text-shadow-black text-shadow-lg">ثبت نام</span>
    <span class="font-bold text-[18px] text-white block text-shadow-black text-shadow-lg">
        خوش آمدید، فرم عضویت را تکمیل کنید
    </span>

    <div id="auth-register-email-field" class="mt-4 bg-gray-300 rounded-2xl
    w-fit cursor-pointer mx-auto pl-4 hover:scale-105 duration-300 overflow-hidden">
        <img class="inline bg-gray-500" src="{{ config('images.ftp_path') . '/files/icon/arrow-24.png' }}"
            loading="lazy">
        <span id="auth-register-email-span" class="inline"></span>
    </div>

    <div class="flex flex-col">
        <input type="hidden" name="email" id="auth-register-email-input">

        <div class="mt-4 text-right flex flex-col">
            <span class="text-white text-[20px] font-bold">نام</span>
            <input type="text" name="name" id="auth-register-name-input" class="bg-white rounded text-2xl p-2"
                placeholder="نام شما...">
        </div>
        <div class="mt-4 text-right flex flex-col">
            <span class="text-white text-[20px] font-bold">نام کاربری
                <span class="text-red-300">(غیر قابل تغییر)</span>
            </span>
            <input type="text" name="username" id="auth-register-username-input" class="bg-white rounded text-2xl p-2"
                placeholder="نام کاربری...">
        </div>
        <div class="mt-4 text-right flex flex-col relative">
            <span class="text-white text-[20px] font-bold">رمز عبور
                <span class="text-red-300">(فراموش نکن)</span>
            </span>

            <input type="password" name="password" id="auth-register-password-input"
                class="bg-white rounded text-2xl p-2 pl-12" placeholder="رمز عبور...">

            <!-- eye button -->
            <button type="button" id="auth-register-password-toggle"
                class="absolute left-3 top-11 text-gray-600 hover:text-black">
                🙈
            </button>
        </div>


        <span id="auth-register-error" class=" bg-red-600 rounded-2xl mt-6 py-2 text-[20px]
    hover:bg-red-700 text-white cursor-pointer hidden">
        </span>
        <button type="button" id="auth-register-btn" class=" bg-green-500 rounded-2xl mt-6 py-2
        hover:bg-green-700 text-white cursor-pointer text-2xl">
            <span>ثبت نام</span>
            <img class="inline" src="{{ config('images.ftp_path') . '/files/icon/arrow-left-24.png' }}">
        </button>
    </div>

</div>