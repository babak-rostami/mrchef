<div class="text-center hidden" id="auth-forgot-section">

    <span class="text-2xl font-bold text-white block mb-2 text-shadow-black text-shadow-lg">
        تغییر رمز عبور
    </span>
    <span class="font-bold text-[18px] text-white block text-shadow-black text-shadow-lg">
        ایمیل اکانت خود را وارد کنید
    </span>

    <div class="flex flex-col">
        <input type="text" id="auth-forgot-email-input" class="bg-white rounded-2xl mt-4 text-2xl p-2"
            placeholder="ایمیل خود را وارد کنید...">

        <span id="auth-forgot-error"
            class=" bg-red-600 rounded-2xl mt-6 py-2 text-[20px]
    hover:bg-red-700 text-white cursor-pointer hidden mb-8">
        </span>
        <button type="button" id="auth-forgot-btn"
            class=" bg-green-500 rounded-2xl mt-6 py-2
        hover:bg-green-700 text-white cursor-pointer text-2xl mb-8">
            <span>ارسال ایمیل بازیابی</span>
            <img class="inline" src="{{ asset('files/icon/arrow-left-24.png') }}">
        </button>

        <span id="auth-forgot-login-btn"
            class="text-white hover:text-blue-300 font-bold hover:scale-105 duration-300 cursor-pointer inline mx-auto">
            ورود به حساب</span>
    </div>

</div>
