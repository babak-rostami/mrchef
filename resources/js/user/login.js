const passwordInput = document.getElementById("auth-login-password-input");
const emailInput = document.getElementById("auth-login-email-input");

const submitBtn = document.getElementById("auth-login-btn");
const submitBtnText = submitBtn.querySelector("span");
const submitBtnImg = submitBtn.querySelector("img");
const errorSpan = document.getElementById("auth-login-error");

const passwordToggle = document.getElementById("auth-login-password-toggle");

/* ======================
   Utils
====================== */
function showLoginError(message) {
    submitBtn.classList.add("hidden");

    errorSpan.textContent = message;
    errorSpan.classList.remove("hidden");

    setTimeout(() => {
        errorSpan.classList.add("hidden");
        errorSpan.textContent = "";
        submitBtn.classList.remove("hidden");
    }, 6000);
}

/* ======================
   Password toggle
====================== */
passwordToggle.addEventListener("click", () => {
    const isText = passwordInput.type === "text";
    passwordInput.type = isText ? "password" : "text";
    passwordToggle.textContent = isText ? "🙈" : "👁";
});

/* ======================
   Submit (AJAX)
====================== */
submitBtn.addEventListener("click", async function () {
    const password = passwordInput.value.trim();
    const email = emailInput.value.trim();

    if (!password) return showLoginError("رمز عبور خود را وارد کنید");

    submitBtn.disabled = true;
    submitBtn.classList.add("opacity-70", "cursor-not-allowed");
    submitBtnText.textContent = "در حال بررسی اطلاعات...";
    submitBtnImg.classList.remove("inline");
    submitBtnImg.classList.add("hidden");

    try {
        const response = await axios.post("/login", {
            email,
            password,
        });

        // لاگین موفق
        window.location.reload();
    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.classList.remove("opacity-70", "cursor-not-allowed");
        submitBtnText.textContent = "ورود";
        submitBtnImg.classList.remove("hidden");
        submitBtnImg.classList.add("inline");

        // 🔥 هندل validation لاراول
        if (error.response?.status === 422) {
            const errors = error.response.data.errors;
            if (errors?.password) {
                showLoginError(errors.password[0]);
            }
            return;
        }
        if (error.response?.status === 401) {
            const message = error.response.data.message;
            showLoginError(message);
            return;
        }

        showLoginError("خطایی رخ داد، دوباره تلاش کنید");
    }
});
