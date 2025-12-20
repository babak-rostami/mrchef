<div class="text-center hidden" id="auth-login-section">

    <div id="auth-login-email-field"
        class="mt-4 bg-gray-300 rounded-2xl
    w-fit cursor-pointer mx-auto pl-4 hover:scale-105 duration-300 overflow-hidden mb-4">
        <img class="inline bg-gray-500" src="{{ asset('files/icon/arrow-24.png') }}" loading="lazy">
        <span class="inline">تغییر حساب</span>
    </div>

    <span class="text-2xl font-bold text-white block mb-2 text-shadow-black text-shadow-lg">
        سلام <span id="auth-login-username-span"></span>
    </span>
    <span class="font-bold text-[18px] text-white block text-shadow-black text-shadow-lg">
        برای ورود رمز عبور خود را وارد کنید
    </span>

    <div class="flex flex-col">
        <input type="hidden" name="email" id="auth-login-email-input">

        <div class="mt-4 text-right flex flex-col relative">
            <span class="text-white text-[20px] font-bold">رمز عبور</span>

            <input type="password" name="password" id="auth-login-password-input"
                class="bg-white rounded text-2xl p-2 pl-12" placeholder="رمز عبور...">

            <!-- eye button -->
            <button type="button" id="auth-login-password-toggle"
                class="absolute left-3 top-11 text-gray-600 hover:text-black">
                🙈
            </button>
        </div>

        <span id="auth-login-error"
            class=" bg-red-600 rounded-2xl mt-6 py-2 text-[20px]
    hover:bg-red-700 text-white cursor-pointer hidden mb-8">
        </span>
        <button type="button" id="auth-login-btn"
            class=" bg-green-500 rounded-2xl mt-6 py-2
        hover:bg-green-700 text-white cursor-pointer text-2xl mb-8">
            <span>ورود</span>
            <img class="inline" src="{{ asset('files/icon/arrow-left-24.png') }}">
        </button>

        <span id="auth-login-forgot-btn"
            class="text-white hover:text-blue-300 font-bold hover:scale-105 duration-300 cursor-pointer inline mx-auto">
            رمز عبور خود را فراموش کرده ام</span>
    </div>

</div>
