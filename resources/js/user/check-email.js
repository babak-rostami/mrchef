const check_email_input = document.getElementById("login-email-check");
const check_email_btn = document.getElementById("login-email-check-btn");
const check_email_error = document.getElementById("login-email-check-error");

check_email_input.addEventListener("keydown", function (e) {
    // جلوگیری از Enter و Space
    if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
    }
});

check_email_input.addEventListener("input", function () {
    // حذف همه space ها
    this.value = this.value.replace(/\s+/g, "");
});

check_email_btn.addEventListener("click", async function () {
    const email = check_email_input.value.trim();

    if (!email) {
        showEmailError("لطفاً ایمیل خود را وارد کنید");
        return;
    }

    if (!isValidEmail(email)) {
        showEmailError("یک فرمت ایمیل معتبر وارد کنید");
        return;
    }

    check_email_btn.disabled = true;
    check_email_btn.classList.add("opacity-70", "cursor-not-allowed");

    try {
        const response = await axios.post("/check-email-exist", { email });

        if (response.data.exists) {
            checkEmailSectionShow(0);
            loginSectionShow(1, email, response.data.username);
        } else if (response.data.exists === false) {
            checkEmailSectionShow(0);
            registerSectionShow(1, email);
        }
    } catch (error) {
        if (error.response?.data?.message) {
            showEmailError(error.response.data.message);
        } else {
            showEmailError("خطایی رخ داد، دوباره تلاش کنید");
        }
    } finally {
        check_email_btn.disabled = false;
        check_email_btn.classList.remove("opacity-70", "cursor-not-allowed");
    }
});

function showEmailError(message) {
    check_email_btn.classList.add("hidden");

    check_email_error.textContent = message;
    check_email_error.classList.remove("hidden");

    setTimeout(() => {
        check_email_error.classList.add("hidden");
        check_email_error.textContent = "";
        check_email_btn.classList.remove("hidden");
    }, 5000);
}

function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

document
    .getElementById("auth-register-email-field")
    .addEventListener("click", function () {
        checkEmailSectionShow(1);
        registerSectionShow(0);
    });

document
    .getElementById("auth-login-email-field")
    .addEventListener("click", function () {
        checkEmailSectionShow(1);
        loginSectionShow(0);
    });

document
    .getElementById("auth-login-forgot-btn")
    .addEventListener("click", function () {
        forgotSectionShow(1);
        loginSectionShow(0);
    });

document
    .getElementById("auth-forgot-login-btn")
    .addEventListener("click", function () {
        forgotSectionShow(0);
        checkEmailSectionShow(1);
    });

function checkEmailSectionShow(show) {
    const check_email_section = document.getElementById(
        "auth-check-email-section"
    );

    if (show === 1) {
        check_email_section.classList.remove("hidden");
    } else {
        check_email_section.classList.add("hidden");
    }
}

function registerSectionShow(show, email) {
    const register_section = document.getElementById("auth-register-section");

    if (show === 1) {
        register_section.classList.remove("hidden");
        const email_span = document.getElementById("auth-register-email-span");
        const email_input = document.getElementById(
            "auth-register-email-input"
        );
        email_input.value = email;
        email_span.innerText = email;
    } else {
        register_section.classList.add("hidden");
    }
}

function loginSectionShow(show, email, username) {
    const login_section = document.getElementById("auth-login-section");

    if (show === 1) {
        login_section.classList.remove("hidden");
        const username_span = document.getElementById(
            "auth-login-username-span"
        );
        const email_input = document.getElementById("auth-login-email-input");
        email_input.value = email;
        username_span.innerText = username;

        login_section.classList.remove("hidden");
    } else {
        login_section.classList.add("hidden");
    }
}

function forgotSectionShow(show) {
    const forgot_section = document.getElementById("auth-forgot-section");

    if (show === 1) {
        forgot_section.classList.remove("hidden");
        const email_input = document.getElementById("auth-forgot-email-input");

        const login_email_input = document.getElementById(
            "auth-login-email-input"
        );
        const email = login_email_input.value;

        forgot_section.classList.remove("hidden");

        if (email_input.classList.contains("cursor-not-allowed")) {
            return;
        }
        email_input.value = email;
    } else {
        forgot_section.classList.add("hidden");
    }
}
