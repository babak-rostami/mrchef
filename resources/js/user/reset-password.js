const form = document.getElementById("reset-password-form");

const submitBtn = document.getElementById("auth-reset-btn");
const submitBtnText = submitBtn.querySelector("span");
const submitBtnImg = submitBtn.querySelector("img");
const errorSpan = document.getElementById("auth-reset-error");

const emailInput = document.getElementById("auth-reset-email-input");
const resetPasswordToggle = document.getElementById(
    "auth-reset-password-toggle",
);
const passwordInput = document.getElementById("auth-reset-password-input");
const resetPasswordToggle2 = document.getElementById(
    "auth-reset-password2-toggle",
);
const passwordInput2 = document.getElementById("auth-reset-password2-input");

/* ======================
   Utils
====================== */
function showResetError(message) {
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

resetPasswordToggle.addEventListener("click", () => {
    const isText = passwordInput.type === "text";
    passwordInput.type = isText ? "password" : "text";
    resetPasswordToggle.textContent = isText ? "🙈" : "👁";
});

resetPasswordToggle2.addEventListener("click", () => {
    const isText = passwordInput2.type === "text";
    passwordInput2.type = isText ? "password" : "text";
    resetPasswordToggle2.textContent = isText ? "🙈" : "👁";
});

/* ======================
   Submit (AJAX)
====================== */
submitBtn.addEventListener("click", async function () {
    const password = passwordInput.value.trim();
    const password_confirmation = passwordInput2.value.trim();
    const email = emailInput.value.trim();
    const token = document.querySelector('input[name="token"]').value;

    if (password !== password_confirmation) {
        showResetError("تکرار رمز عبور یکسان نمی باشد");
        return;
    }

    if (!password || password.length < 6)
        return showResetError("رمز عبور باید حداقل 6 کاراکتر باشد");

    submitBtn.disabled = true;
    submitBtn.classList.add("opacity-70", "cursor-not-allowed");
    submitBtn.textContent = "در حال ثبت...";

    try {
        const response = await axios.post("/reset-password", {
            email,
            password,
            password_confirmation,
            token,
        });

        window.location.href = response.data.redirect;
    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.classList.remove("opacity-70", "cursor-not-allowed");
        submitBtn.textContent = "تغییر رمز عبور";

        if (error.response?.status === 422) {
            const errors = error.response.data.errors;

            if (errors.email) return showResetError(errors.email[0]);

            if (errors.password) return showResetError(errors.password[0]);

            if (errors.token) return showResetError(errors.token[0]);

            return showResetError("اطلاعات وارد شده معتبر نیست");
        }

        showResetError("خطایی رخ داد، دوباره تلاش کنید");
    }
});
