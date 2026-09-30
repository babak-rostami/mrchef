/**
 * یه رشته‌ی HTML رو به یه المان DOM واقعی تبدیل می‌کنه (بدون این‌که جایی
 * درجش کنه). برای وقتی که سرور یه تکه HTML آماده برمی‌گردونه و قبل از
 * اضافه‌کردنش به صفحه، لازمه بهش دسترسی داشته باشیم (مثلاً برای خوندن id).
 */
export function htmlToElement(html) {
    const wrapper = document.createElement("div");
    wrapper.innerHTML = html.trim();
    return wrapper.firstElementChild;
}

/**
 * به یه المان اسکرول نرم می‌کنه و چند ثانیه یه رنگ خاص روش نگه می‌داره
 * تا کاربر متوجه بشه همین الان اضافه شده (مثلاً بعد از ثبت نظر).
 *
 * برای این‌که انیمیشن کار کنه، خودِ المان باید کلاس bcomment-item رو
 * داشته باشه (transition روی همین کلاس تعریف شده — نگاه کن به
 * resources/css/component/comment/index.css).
 */
export function scrollToAndHighlight(elementId) {
    const el = document.getElementById(elementId);
    if (!el) return;

    el.scrollIntoView({ behavior: "smooth", block: "center" });

    el.classList.add("bcomment-highlight");
    setTimeout(() => {
        el.classList.remove("bcomment-highlight");
    }, 2000);
}
