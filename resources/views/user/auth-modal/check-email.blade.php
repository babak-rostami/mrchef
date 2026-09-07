<div class="text-center flex flex-col" id="auth-check-email-section">
    <span class="text-2xl font-bold text-white block mb-4 text-shadow-black text-shadow-lg">خوش اومدی 👋</span>
    <span class="font-bold text-[20px] text-white block text-shadow-black text-shadow-lg">برای ادامه فعالیت ایمیل خود
        را وارد کنید</span>

    <input type="text" name="login_email_check" id="login-email-check" class="bg-white rounded-2xl mt-4 text-2xl p-2"
        placeholder="ایمیل خود را وارد کنید...">

    <span id="login-email-check-error" class="w-full bg-red-600 rounded-2xl mt-3 py-2 text-[20px]
    hover:bg-red-700 text-white cursor-pointer hidden">
    </span>

    <button id="login-email-check-btn" class="w-full bg-blue-500 rounded-2xl mt-3 py-2
    hover:bg-blue-700 text-white cursor-pointer text-2xl">
        <span>ادامه</span>
        <img class="inline" src="{{ config('images.ftp_path') . '/files/icon/arrow-left-24.png' }}">
    </button>

</div>