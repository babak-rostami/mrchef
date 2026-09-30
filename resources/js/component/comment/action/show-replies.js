import axios from "axios";

/**
 * پاسخ‌های یه کامنت رو (اگه قبلاً لود نشده باشن) از سرور، به‌صورت HTML
 * آماده‌ی رندرشده، می‌گیره و توی باکس مربوطه می‌ذاره.
 * اگه از قبل لود شده باشن، هیچ درخواستی نمی‌زنه.
 */
export async function loadReplies(commentId) {
    const btn = document.getElementById(`show-replies-btn-${commentId}`);
    const box = document.getElementById(`replies-box-${commentId}`);
    if (!btn || !box || btn.dataset.loaded === "true") return;

    btn.dataset.loading = "true";
    btn.disabled = true;
    btn.classList.add("opacity-60", "cursor-not-allowed");

    try {
        const response = await axios.get(`/show-comment-replies/${commentId}`);
        box.innerHTML = response.data.html;
        btn.dataset.loaded = "true";
    } catch (error) {
        console.error("loadReplies error", error);
    } finally {
        btn.dataset.loading = "false";
        btn.disabled = false;
        btn.classList.remove("opacity-60", "cursor-not-allowed");
    }
}

/**
 * دکمه‌ی «مشاهده N پاسخ». اولین کلیک از سرور می‌گیره؛ دفعات بعد فقط
 * باز/بسته می‌کنه، بدون درخواست جدید.
 */
async function showReplies(commentId) {
    const btn = document.getElementById(`show-replies-btn-${commentId}`);
    const box = document.getElementById(`replies-box-${commentId}`);
    if (!btn || !box || btn.dataset.loading === "true") return;

    if (btn.dataset.loaded !== "true") {
        await loadReplies(commentId);
        box.classList.remove("hidden");
        btn.dataset.open = "true";
        btn.textContent = "پنهان کردن پاسخ‌ها";
        return;
    }

    const isOpen = btn.dataset.open === "true";

    if (isOpen) {
        box.classList.add("hidden");
        btn.textContent = "نمایش پاسخ‌ها";
        btn.dataset.open = "false";
    } else {
        box.classList.remove("hidden");
        btn.textContent = "پنهان کردن پاسخ‌ها";
        btn.dataset.open = "true";
    }
}

window.showReplies = showReplies;
