import axios from "axios";

/**
 * دکمه‌ی «نمایش نظرات بیشتر».
 *
 * تعداد نظرِ هر بار رو خودِ سرور تعیین می‌کنه (Comment::PER_PAGE) — اینجا
 * لازم نیست عددی تکرار بشه. جاوااسکریپت فقط offset فعلی رو (از
 * data-offset روی #comments-box) می‌فرسته و هر چقدر برگشت رو اضافه می‌کنه.
 *
 * دکمه وقتی حذف میشه که سرور بگه has_more=false.
 */
async function loadMoreComments() {
    const box = document.getElementById("comments-box");
    const btn = document.getElementById("load-more-comments-btn");
    if (!box || !btn || btn.dataset.loading === "true") return;

    const originalText = btn.textContent;
    btn.dataset.loading = "true";
    btn.disabled = true;
    btn.textContent = "در حال بارگذاری...";

    const currentOffset = parseInt(box.dataset.offset, 10) || 0;

    try {
        const response = await axios.get("/load-more-comments", {
            params: {
                page: box.dataset.page,
                object_id: box.dataset.objectId,
                offset: currentOffset,
            },
        });

        const { html, count, has_more } = response.data;

        const wrapper = document.createElement("div");
        wrapper.innerHTML = html;

        // اگه بین دو بار لود، کاربر دیگه‌ای هم نظر گذاشته باشه، ردیف‌ها توی
        // دیتابیس یکی شیفت می‌خورن و ممکنه نظری که از قبل توی صفحه هست
        // دوباره برگرده. اونایی که id‌شون از قبل توی صفحه هست رو کنار می‌ذاریم.
        // (offset رو ولی با count سرور جلو می‌بریم، نه با تعداد اضافه‌شده‌ها.)
        [...wrapper.children].forEach((el) => {
            if (el.id && document.getElementById(el.id)) el.remove();
        });

        // اول اولین المان جدید رو نگه می‌داریم، چون بعد از append کردن
        // wrapper خالی میشه.
        const firstNewEl = wrapper.firstElementChild;

        box.append(...wrapper.childNodes);
        box.dataset.offset = currentOffset + count;

        if (has_more) {
            btn.dataset.loading = "false";
            btn.disabled = false;
            btn.textContent = originalText;
        } else {
            btn.remove();
        }

        // اسکرول به اولین نظر تازه‌لودشده تا کاربر همون‌جا رو ببینه
        if (firstNewEl) {
            firstNewEl.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    } catch (error) {
        console.error("loadMoreComments error", error);
        btn.dataset.loading = "false";
        btn.disabled = false;
        btn.textContent = originalText;
    }
}

function init() {
    document
        .getElementById("load-more-comments-btn")
        ?.addEventListener("click", loadMoreComments);
}

// اگه ماژول بعد از DOMContentLoaded اجرا بشه، دیگه ایونتش fire نمیشه؛
// پس وضعیت رو چک می‌کنیم که در هر دو حالت دکمه وصل بشه.
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
} else {
    init();
}
