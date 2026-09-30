import axios from "axios";
import "./action/reply";
import "./action/reaction";
import "./action/load-more";
import { loadReplies } from "./action/show-replies";
import { isBodyValid } from "./validation/body";
import { requireLoginForForm } from "../../utils/require-login";
import { scrollToAndHighlight, htmlToElement } from "./dom";

/**
 * نقطه‌ی ورود اصلی: هم فرم کامنت اصلی و هم فرم ریپلای همینو صدا میزنن.
 */
function sendComment(form_id, body_id, section) {
    if (!isBodyValid(body_id, section)) return;

    const form = document.getElementById(form_id);

    // اگه کاربر لاگین نباشه، مودال لاگین باز میشه و بعد از لاگین موفق
    // (که صفحه رفرش میشه)، دقیقاً همین تابع با همین آرگومان‌ها دوباره
    // صدا زده میشه. چون فرم AJAX ئه، نمیشه فقط form.submit() کرد.
    requireLoginForForm(form, () => submitCommentForm(form, section), {
        fn: "sendComment",
        args: [form_id, body_id, section],
    });
}

async function submitCommentForm(form, section) {
    disableSubmitButton(section);
    removeErrors();

    try {
        const response = await axios.post(form.action, new FormData(form));
        const { is_reply, parent_id, html, toggle_html } = response.data;

        if (is_reply) {
            await attachReply(parent_id, html, toggle_html);
        } else {
            attachTopLevelComment(html);
        }

        resetForm(section);
    } catch (error) {
        showSubmitError(section, error);
    } finally {
        enableSubmitButton(section);
    }
}

/**
 * کامنت‌های اصلی از جدید به قدیم نشون داده میشن، پس کامنت تازه همیشه
 * اول لیست میره. data-offset رو هم یکی زیاد می‌کنیم تا «نمایش نظرات
 * بیشتر» بعداً همین کامنت رو دوباره نیاره (چون offset بر اساس تعداد
 * کامنت‌های الان-توی-صفحه‌ست).
 */
function attachTopLevelComment(html) {
    const box = document.getElementById("comments-box");
    const newEl = htmlToElement(html);
    if (!box || !newEl) return;

    box.prepend(newEl);
    box.dataset.offset = (parseInt(box.dataset.offset, 10) || 0) + 1;

    scrollToAndHighlight(newEl.id);
}

/**
 * پاسخ‌ها همیشه از قدیم به جدید هستن، پس پاسخ تازه ته لیست پاسخ‌ها
 * میره (برخلاف کامنت اصلی، عمداً).
 *
 * سه حالت وجود داره:
 *  ۱) پاسخ‌ها از قبل لود شده بودن → پاسخ تازه رو دستی ته لیست اضافه می‌کنیم.
 *  ۲) هنوز لود نشده بودن → اول از سرور لودشون می‌کنیم. چون پاسخ تازه از
 *     قبل توی دیتابیس بوده، جزو همون پاسخ‌های لودشده‌ست؛ دیگه دستی اضافه‌ش
 *     نمی‌کنیم، وگرنه دوبار نشون داده میشه.
 *  ۳) لود لازم بود ولی شکست خورد → دستی اضافه‌ش می‌کنیم که حداقل خودش
 *     دیده بشه.
 */
async function attachReply(parentId, replyHtml, toggleHtml) {
    let btn = document.getElementById(`show-replies-btn-${parentId}`);
    let box = document.getElementById(`replies-box-${parentId}`);

    if (!btn || !box) {
        // این اولین پاسخ این کامنته؛ دکمه/باکس هنوز توی صفحه نبودن، می‌سازیمشون
        const parentCard = document.getElementById(`comment-box-${parentId}`);
        if (!parentCard || !toggleHtml) return;

        parentCard.insertAdjacentHTML("beforeend", toggleHtml);
        btn = document.getElementById(`show-replies-btn-${parentId}`);
        box = document.getElementById(`replies-box-${parentId}`);
        if (!btn || !box) return;
    }

    const neededLoad = btn.dataset.loaded !== "true";
    if (neededLoad) {
        await loadReplies(parentId);
    }

    const alreadyShownFromLoad = neededLoad && btn.dataset.loaded === "true";
    const newEl = htmlToElement(replyHtml);

    if (!alreadyShownFromLoad && newEl) {
        box.appendChild(newEl);
    }

    box.classList.remove("hidden");
    btn.dataset.open = "true";
    btn.textContent = "پنهان کردن پاسخ‌ها";

    // حتی وقتی خودمون درجش نکردیم (حالت ۲)، یه المان با همین id از لود
    // تازه توی صفحه هست؛ پس اسکرول/هایلایت با id همیشه درست کار می‌کنه.
    if (newEl) scrollToAndHighlight(newEl.id);
}

function resetForm(section) {
    const bodyField =
        section === "comment"
            ? document.getElementById("bcom-body")
            : document.getElementById("bcom-rep-body");

    if (bodyField) bodyField.value = "";

    if (
        section === "reply" &&
        typeof window.closeBComReplyModal === "function"
    ) {
        window.closeBComReplyModal();
    }
}

function removeErrors() {
    document.getElementById("bcom-body-error")?.classList.add("hidden");
    document.getElementById("bcom-rep-body-error")?.classList.add("hidden");
}

function showSubmitError(section, error) {
    const errorBox =
        section === "comment"
            ? document.getElementById("bcom-body-error")
            : document.getElementById("bcom-rep-body-error");

    let message = "خطایی رخ داد، دوباره تلاش کنید";

    if (error.response?.status === 422) {
        message = error.response.data.errors?.body?.[0] || message;
    }

    if (errorBox) {
        errorBox.textContent = message;
        errorBox.classList.remove("hidden");
    }
}

function disableSubmitButton(section) {
    const submit_btn =
        section === "comment"
            ? document.getElementById("bcom-submit")
            : document.getElementById("bcom-reply-submit");

    submit_btn.disabled = true;
    submit_btn.classList.add("opacity-50", "cursor-not-allowed");
    submit_btn.classList.remove("cursor-pointer");
    submit_btn.innerText = "منتظر بمانید...";
}

function enableSubmitButton(section) {
    const submit_btn =
        section === "comment"
            ? document.getElementById("bcom-submit")
            : document.getElementById("bcom-reply-submit");

    submit_btn.disabled = false;
    submit_btn.classList.remove("opacity-50", "cursor-not-allowed");
    submit_btn.classList.add("cursor-pointer");
    submit_btn.innerText = "ثبت نظر";
}

window.sendComment = sendComment;
