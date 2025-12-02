// وقتی کاربر اسکرول میکنه بعد ول میکنه لینک کلیک میشه
//میخوام فقط در حالی کلیک بشه که اسکرول نکرده باشه
window.createSlider = function (
    sliderElement,
    itemClass,
    no_scroll = 0,
    scroll_time = 4000,
    scroll_smooth = 0
) {
    // --- حالت‌ها و متغیرهای مورد نیاز ---
    let isDown = false;          // آیا انگشت/ماوس پایین است؟
    let dragging = false;        // آیا حرکت افقی تشخیص داده شده؟
    let moved = false;           // آیا حتی 1px حرکت شده؟
    let startX = 0;              // مختصات شروع X
    let startY = 0;              // مختصات شروع Y
    let scrollLeft = 0;          // مقدار اسکرول هنگام شروع
    let velX = 0;                // سرعت حرکت اسکرول (برای مومنتوم)
    let momentumID = null;       // ID انیمیشن مومنتوم
    let selected_a = null;       // لینک انتخاب‌شده برای کلیک

    // -----------------------------
    // 📌 ماوس (برای دسکتاپ)
    // -----------------------------

    sliderElement.addEventListener("mousedown", (e) => {
        if (e.button !== 0) return; // فقط دکمه چپ

        isDown = true;
        dragging = false;
        moved = false;

        startX = e.pageX - sliderElement.offsetLeft;
        scrollLeft = sliderElement.scrollLeft;

        cancelMomentumTracking();

        let anchor = e.target.closest("a");
        selected_a = anchor ? anchor.id : null;
    });

    sliderElement.addEventListener("mousemove", (e) => {
        if (!isDown) return;

        const x = e.pageX - sliderElement.offsetLeft;
        const dx = x - startX;

        // اولین تشخیص حرکت افقی
        if (!dragging && Math.abs(dx) > 8) {
            dragging = true;
            selected_a = null; // کلیک لغو می‌شود
        }

        if (!dragging) return;

        let prev = sliderElement.scrollLeft;
        sliderElement.scrollLeft = scrollLeft - dx * 0.8;
        velX = sliderElement.scrollLeft - prev;
        if (sliderElement.scrollLeft !== prev) moved = true;
    });

    sliderElement.addEventListener("mouseup", () => {
        isDown = false;

        if (dragging) {
            beginMomentumTracking(); // شروع مومنتوم
        } else if (!moved && selected_a) {
            document.getElementById(selected_a).click(); // کلیک واقعی
        }

        dragging = false;
        selected_a = null;
    });

    sliderElement.addEventListener("mouseleave", () => {
        isDown = false;
        dragging = false;
    });

    // --- جلوگیری از کلیک ناخواسته هنگام درگ ---
    sliderElement.addEventListener("click", (e) => {
        if (dragging || moved) e.preventDefault();
    });

    // -----------------------------
    // 📌 تاچ (برای موبایل)
    // -----------------------------

    sliderElement.addEventListener("touchstart", (e) => {
        const t = e.touches[0];

        isDown = true;
        dragging = false;
        moved = false;

        startX = t.clientX;
        startY = t.clientY;
        scrollLeft = sliderElement.scrollLeft;

        let anchor = e.target.closest("a");
        selected_a = anchor ? anchor.id : null;

        cancelMomentumTracking();
    });

    sliderElement.addEventListener("touchmove", (e) => {
        if (!isDown) return;

        const t = e.touches[0];
        const dx = t.clientX - startX;
        const dy = t.clientY - startY;

        // تعیین جهت - اگر حرکت عمودی بود: اجازه بده صفحه اسکرول بشه
        if (!dragging) {
            if (Math.abs(dy) > Math.abs(dx)) {
                isDown = false;     // اجازه خروج از مود درگ
                return;             // اسکرول عمودی فعال شود
            }

            // اگر حرکت افقی تشخیص داده شد
            if (Math.abs(dx) > 10) {
                dragging = true;
                selected_a = null; // کلیک لغو
            } else {
                return; // هنوز جهت مشخص نشده
            }
        }

        // از اینجا به بعد: فقط drag افقی
        if (e.cancelable) e.preventDefault();

        let prev = sliderElement.scrollLeft;
        sliderElement.scrollLeft = scrollLeft - dx * 0.8;
        velX = sliderElement.scrollLeft - prev;
        if (sliderElement.scrollLeft !== prev) moved = true;
    });

    sliderElement.addEventListener("touchend", () => {
        if (dragging) {
            beginMomentumTracking();
        } else if (!moved && selected_a) {
            document.getElementById(selected_a)?.click();
        }

        isDown = false;
        dragging = false;
    });

    // -----------------------------
    // 📌 مومنتوم (حرکت نرم پس از رها کردن)
    // -----------------------------

    function beginMomentumTracking() {
        cancelMomentumTracking();
        momentumID = requestAnimationFrame(momentumLoop);
    }

    function cancelMomentumTracking() {
        cancelAnimationFrame(momentumID);
    }

    function momentumLoop() {
        sliderElement.scrollLeft += velX;
        velX *= 0.95; // کاهش سرعت

        if (Math.abs(velX) > 0.5) {
            momentumID = requestAnimationFrame(momentumLoop);
        }
    }
};
