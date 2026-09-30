// این ماژول یه سیستم generic برای «این کار نیاز به لاگینه» میسازه.
// راهنمای کامل استفاده و کپی به پروژه‌ی دیگه: docs/require-login-system.md
//
// خلاصه:
// - اگه کاربر لاگین باشه، کار همون لحظه انجام میشه.
// - اگه لاگین نباشه، مودال لاگین (#user-login) باز میشه؛ بعد از لاگین موفق
//   (که صفحه رفرش میشه)، همون کار خودش دوباره اجرا میشه، بدون این‌که چیزی
//   که کاربر تایپ کرده بود از دست بره.
//
// تضمین‌های ایمنی — اطلاعات معلق در این حالت‌ها پاک میشه/resume نمیشه:
//   ۱) مودال لاگین بدون لاگین موفق بسته بشه (✕، کلیک روی پس‌زمینه، Esc).
//   ۲) صفحه‌ی جدیدی باز بشه که آدرسش با صفحه‌ی ذخیره‌شده فرق داره
//      (فوراً موقع لود پاک میشه، حتی اگه کاربر هنوز لاگین نباشه).
//   ۳) بیشتر از ۱۵ دقیقه گذشته باشه (محافظ نهایی).

const FORM_STORAGE_KEY = "mrchef_pending_form";
const ACTION_STORAGE_KEY = "mrchef_pending_action";
const ALL_KEYS = [FORM_STORAGE_KEY, ACTION_STORAGE_KEY];

// بعد از این مدت، اکشن معلق دیگه resume نمیشه.
const EXPIRY_MS = 15 * 60 * 1000; // 15 دقیقه

// اگه فرمِ مقصد موقع resume هنوز توی DOM نبود، چند بار با فاصله‌ی کوتاه
// دنبالش می‌گردیم (حداکثر ~۱ ثانیه) قبل از این‌که بی‌خیال بشیم.
const FORM_WAIT_ATTEMPTS = 10;
const FORM_WAIT_INTERVAL_MS = 100;

const actionRegistry = {};

/**
 * یه اکشن غیر-فرمی رو با یه اسم ثبت می‌کنه تا بعداً requireLogin بتونه
 * صداش بزنه. حتماً موقع لود شدن فایل صدا بزن، نه موقع کلیک.
 */
export function registerAction(name, handler) {
    actionRegistry[name] = handler;
}

/**
 * برای فرم‌ها.
 * form:    خود المان <form>
 * onReady: کاری که وقتی کاربر لاگینه باید انجام بشه
 * resume:  (اختیاری) { fn: 'اسم تابع global', args: [...] } — بعد از لاگین،
 *          همین تابع دوباره صدا زده میشه. ندی → خود فرم submit عادی میشه.
 */
export function requireLoginForForm(form, onReady, resume = null) {
    if (!window.isGuest) {
        onReady();
        return;
    }

    const values = {};
    form.querySelectorAll("[name]").forEach((field) => {
        if (field.name === "_token") return; // توکن CSRF بعد از لاگین عوض میشه، دست نمی‌زنیم
        values[field.name] = field.value;
    });

    savePending(FORM_STORAGE_KEY, { formId: form.id, values, resume });
    openModal("user-login");
}

/**
 * برای عملیات غیر-فرمی. قبلش باید با registerAction ثبت شده باشه.
 */
export function requireLogin(actionName, payload = {}) {
    const handler = actionRegistry[actionName];
    if (!handler) {
        console.error(
            `requireLogin: اکشن "${actionName}" ثبت نشده. اول با registerAction ثبتش کن.`,
        );
        return;
    }

    if (!window.isGuest) {
        handler(payload);
        return;
    }

    savePending(ACTION_STORAGE_KEY, { actionName, payload });
    openModal("user-login");
}

/**
 * موقع لود شدن هر صفحه (از app.js) صدا زده میشه.
 */
export function resumePendingAuthAction() {
    // همیشه، حتی اگه هنوز لاگین نکرده: هر چیز معلقِ مال یه صفحه‌ی دیگه رو پاک کن.
    clearPendingFromOtherPages();

    if (window.isGuest) return;

    const pendingForm = readAndClear(FORM_STORAGE_KEY);
    if (pendingForm) {
        resumeForm(pendingForm);
        return; // در آن واحد فقط یکی از این دوتا معلق می‌مونه
    }

    const pendingAction = readAndClear(ACTION_STORAGE_KEY);
    if (pendingAction) {
        const handler = actionRegistry[pendingAction.actionName];
        if (handler) handler(pendingAction.payload);
    }
}

// وقتی مودال لاگین بدون لاگین موفق بسته میشه (✕، پس‌زمینه، یا Esc)، هر
// چیز معلقی رو پاک می‌کنیم. اگه لاگین موفق بوده، صفحه داره رفرش میشه و
// window.isGuest دیگه true نیست، پس این شرط رد میشه و کاری نمی‌کنیم.
document.addEventListener("modal:closed", (e) => {
    if (e.detail.id !== "user-login") return;
    if (!window.isGuest) return;

    ALL_KEYS.forEach((key) => sessionStorage.removeItem(key));
});

// ───────────────────────── داخلی ─────────────────────────

function currentUrl() {
    return window.location.pathname + window.location.search;
}

function savePending(key, data) {
    sessionStorage.setItem(
        key,
        JSON.stringify({ ...data, storedAt: Date.now(), url: currentUrl() }),
    );
}

function parseStored(raw) {
    try {
        return JSON.parse(raw);
    } catch {
        return null;
    }
}

/**
 * هر چیز معلقی که آدرسش با صفحه‌ی فعلی یکی نیست رو همین لحظه پاک می‌کنه.
 */
function clearPendingFromOtherPages() {
    ALL_KEYS.forEach((key) => {
        const raw = sessionStorage.getItem(key);
        if (!raw) return;

        const data = parseStored(raw);
        if (!data || data.url !== currentUrl()) {
            sessionStorage.removeItem(key);
        }
    });
}

/**
 * می‌خونه و همون لحظه پاک می‌کنه (یک‌بار مصرف). اگه منقضی شده یا مال
 * این صفحه نیست null برمی‌گردونه. (چک آدرس اینجا عمداً دوباره تکرار
 * شده تا حتی اگه یه روز کسی readAndClear رو بدون clearPendingFromOtherPages
 * صدا زد، باز هم ایمن باشه.)
 */
function readAndClear(key) {
    const raw = sessionStorage.getItem(key);
    if (!raw) return null;

    sessionStorage.removeItem(key);

    const data = parseStored(raw);
    if (!data) return null;

    const isExpired = !data.storedAt || Date.now() - data.storedAt > EXPIRY_MS;
    const isSamePage = data.url === currentUrl();

    return isExpired || !isSamePage ? null : data;
}

function resumeForm({ formId, values, resume }) {
    waitForElement(formId, (form) => {
        if (!form) {
            console.warn(
                `require-login: فرم «${formId}» برای ادامه‌ی کار پیدا نشد.`,
            );
            return;
        }

        Object.entries(values).forEach(([name, value]) => {
            const field = form.querySelector(`[name="${name}"]`);
            if (field) field.value = value;
        });

        if (resume && typeof window[resume.fn] === "function") {
            window[resume.fn](...(resume.args || []));
        } else {
            form.submit();
        }
    });
}

/**
 * اگه المان همین الان توی DOM باشه، فوراً callback رو صدا میزنه (بدون هیچ
 * تأخیری). اگه نبود، چند بار با فاصله‌ی کوتاه دوباره چک می‌کنه؛ اگه بعد از
 * همه‌ی تلاش‌ها هم پیدا نشد، callback(null) صدا زده میشه.
 */
function waitForElement(id, callback, attempts = FORM_WAIT_ATTEMPTS) {
    const el = document.getElementById(id);

    if (el) {
        callback(el);
        return;
    }

    if (attempts <= 0) {
        callback(null);
        return;
    }

    setTimeout(
        () => waitForElement(id, callback, attempts - 1),
        FORM_WAIT_INTERVAL_MS,
    );
}
