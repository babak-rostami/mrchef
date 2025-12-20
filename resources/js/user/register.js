const nameInput = document.getElementById("auth-register-name-input");
const usernameInput = document.getElementById("auth-register-username-input");
const passwordInput = document.getElementById("auth-register-password-input");
const emailInput = document.getElementById("auth-register-email-input");

const submitBtn = document.getElementById("auth-register-btn");
const submitBtnText = submitBtn.querySelector("span");
const submitBtnImg = submitBtn.querySelector("img");
const errorSpan = document.getElementById("auth-register-error");

const passwordToggle = document.getElementById("auth-register-password-toggle");

/* ======================
   Utils
====================== */
function showRegisterError(message) {
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
   Field limits
====================== */
nameInput.addEventListener("input", () => {
    nameInput.value = nameInput.value.slice(0, 30);
});

usernameInput.addEventListener("input", () => {
    usernameInput.value = usernameInput.value
        .replace(/[^a-zA-Z0-9.]/g, "")
        .slice(0, 30)
        .replace(/^[0-9.]+/, "")
        .replace(/\.{2,}/g, ".")
        .toLowerCase();
});

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
    const name = nameInput.value.trim();
    const username = usernameInput.value.trim();
    const password = passwordInput.value.trim();
    const email = emailInput.value.trim();

    // validations
    if (!name) return showRegisterError("نام را وارد کنید");
    if (!username) return showRegisterError("نام کاربری را وارد کنید");
    if (!/^[a-zA-Z0-9.]{1,30}$/.test(username))
        return showRegisterError("نام کاربری فقط شامل حروف انگلیسی و عدد باشد");
    if (!password || password.length < 6)
        return showRegisterError("رمز عبور حداقل ۶ کاراکتر باشد");

    submitBtn.disabled = true;
    submitBtn.classList.add("opacity-70", "cursor-not-allowed");
    submitBtnText.textContent = "در حال ثبت اطلاعات...";
    submitBtnImg.classList.remove("inline");
    submitBtnImg.classList.add("hidden");

    try {
        await axios.post("/register", {
            name,
            username,
            email,
            password,
        });

        // ثبت‌نام موفق
        window.location.reload();
    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.classList.remove("opacity-70", "cursor-not-allowed");
        submitBtnText.textContent = "ثبت نام";
        submitBtnImg.classList.remove("hidden");
        submitBtnImg.classList.add("inline");

        // 🔥 هندل validation لاراول
        if (error.response?.status === 422) {
            const errors = error.response.data.errors;

            if (errors?.email) {
                showRegisterError("این ایمیل قبلاً ثبت شده است");
            } else if (errors?.username) {
                showRegisterError(errors.username[0]);
            } else if (errors?.password) {
                showRegisterError(errors.password[0]);
            } else {
                showRegisterError("اطلاعات وارد شده معتبر نیست");
            }
            return;
        }

        showRegisterError("خطایی رخ داد، دوباره تلاش کنید");
    }
});
