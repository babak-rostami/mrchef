const emailInput = document.getElementById("auth-forgot-email-input");

const submitBtn = document.getElementById("auth-forgot-btn");
const submitBtnText = submitBtn.querySelector("span");
const submitBtnImg = submitBtn.querySelector("img");
const errorSpan = document.getElementById("auth-forgot-error");

/* ======================
   Utils
====================== */
function showForgotError(message) {
    submitBtn.classList.add("hidden");

    errorSpan.textContent = message;
    errorSpan.classList.remove("hidden");

    setTimeout(() => {
        errorSpan.classList.add("hidden");
        errorSpan.textContent = "";
        submitBtn.classList.remove("hidden");
    }, 6000);
}

function showForgotSuccess() {
    submitBtn.disabled = true;
    submitBtn.classList.add("opacity-70", "cursor-not-allowed");
    submitBtnText.textContent = "یک ایمیل برای شما ارسال شد";
    submitBtnImg.classList.remove("inline");
    submitBtnImg.classList.add("hidden");
    emailInput.disabled = true;
    emailInput.classList.add("opacity-70", "cursor-not-allowed");
}

function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

emailInput.addEventListener("keydown", function (e) {
    // جلوگیری از Enter و Space
    if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
    }
});

emailInput.addEventListener("input", function () {
    // حذف همه space ها
    this.value = this.value.replace(/\s+/g, "");
});

/* ======================
   Submit (AJAX)
====================== */
submitBtn.addEventListener("click", async function () {
    const email = emailInput.value.trim();

    if (!email) {
        showForgotError("لطفاً ایمیل خود را وارد کنید");
        return;
    }

    if (!isValidEmail(email)) {
        showForgotError("یک فرمت ایمیل معتبر وارد کنید");
        return;
    }

    submitBtn.disabled = true;
    submitBtn.classList.add("opacity-70", "cursor-not-allowed");
    submitBtnText.textContent = "در حال بررسی...";
    submitBtnImg.classList.remove("inline");
    submitBtnImg.classList.add("hidden");

    try {
        await axios.post("/forgot-password", {
            email,
        });

        // ارسال موفق
        showForgotSuccess();
    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.classList.remove("opacity-70", "cursor-not-allowed");
        submitBtnText.textContent = "ارسال ایمیل بازیابی";
        submitBtnImg.classList.remove("hidden");
        submitBtnImg.classList.add("inline");

        // 🔥 هندل validation لاراول
        if (error.response?.status === 422 || error.response?.status === 404) {
            const message = error.response.data.message;
            showForgotError(message);
            return;
        }

        showForgotError("خطایی رخ داد، دوباره تلاش کنید");
    }
});
