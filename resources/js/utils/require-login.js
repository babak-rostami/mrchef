// این ماژول یه سیستم generic برای «این کار نیاز به لاگینه» میسازه:
//
// - اگه کاربر لاگین باشه، کار همون لحظه انجام میشه.
// - اگه لاگین نباشه، مودال لاگین (#user-login) باز میشه. بعد از لاگین یا
//   ثبت‌نام موفق (که صفحه رفرش میشه، طبق کد فعلی login.js/register.js)،
//   همون کاری که کاربر میخواست انجام بده خودش دوباره اجرا میشه —
//   بدون این‌که چیزی که تایپ کرده بود از دست بره.
//
// دو تا ابزار داره:
//
//   requireLoginForForm(form, onReady)
//     برای فرم‌ها (ثبت نظر، ریپلای، و هر فرم دیگه‌ای که بعداً اضافه کنی).
//     مقادیر فیلدهای فرم رو نگه می‌داره و بعد از لاگین، خودش دوباره
//     submit می‌کنه. نیازی نیست چیز دیگه‌ای بنویسی.
//
//   requireLogin(actionName, payload) + registerAction(actionName, handler)
//     برای اکشن‌های غیر-فرمی (مثلاً یه دکمه‌ی «ذخیره» که فقط یه
//     axios.post میزنه، بدون فرم). اول باید توی فایل مربوطه، موقع
//     لود شدن فایل (نه موقع کلیک)، با registerAction ثبتش کنی — چون
//     بعد از رفرش صفحه جاوااسکریپت از اول اجرا میشه و باید بدونه این
//     اسم به کدوم تابع وصله.
//
// مثال استفاده برای یه دکمه‌ی غیر-فرمی در آینده:
//
//   import { registerAction, requireLogin } from '../../utils/require-login';
//
//   registerAction('bookmark-recipe', ({ recipeId }) => {
//       axios.post(`/recipes/${recipeId}/bookmark`);
//   });
//
//   bookmarkBtn.addEventListener('click', () => {
//       requireLogin('bookmark-recipe', { recipeId: 42 });
//   });
//
// نکته‌ی امنیتی: این فقط برای تجربه‌ی کاربریه. روت‌های سمت سرور (مثل
// comment.store) همچنان باید پشت میدل‌ور auth باشن؛ این کد جلوی
// درخواست مستقیم غیرمجاز رو نمی‌گیره، فقط UX رو بهتر می‌کنه.

const FORM_STORAGE_KEY = "mrchef_pending_form";
const ACTION_STORAGE_KEY = "mrchef_pending_action";

// بعد از این مدت، اکشن معلق دیگه resume نمیشه — مثلاً اگه کاربر مودال
// رو باز کرد، بی‌خیال شد، و خیلی بعدتر برای یه کار کاملاً بی‌ربط لاگین کرد.
const EXPIRY_MS = 15 * 60 * 1000; // 15 دقیقه

const actionRegistry = {};

/**
 * یه اکشن غیر-فرمی رو با یه اسم ثبت می‌کنه تا بعداً requireLogin بتونه
 * صداش بزنه. حتماً موقع لود شدن فایل صدا بزن، نه موقع کلیک.
 */
export function registerAction(name, handler) {
    actionRegistry[name] = handler;
}

/**
 * برای عملیاتی که با فرم انجام میشن.
 * form: خود المان <form>
 * onReady: کاری که باید انجام بشه وقتی کاربر لاگینه (یا همین الان، یا
 *          بعد از resume شدن روی صفحه‌ی تازه رفرش‌شده)
 */
export function requireLoginForForm(form, onReady) {
    if (!window.isGuest) {
        onReady();
        return;
    }

    const values = {};
    form.querySelectorAll("[name]").forEach((field) => {
        if (field.name === "_token") return; // توکن CSRF بعد از لاگین عوض میشه، دست نمی‌زنیم
        values[field.name] = field.value;
    });

    sessionStorage.setItem(
        FORM_STORAGE_KEY,
        JSON.stringify({ formId: form.id, values, storedAt: Date.now() }),
    );

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

    sessionStorage.setItem(
        ACTION_STORAGE_KEY,
        JSON.stringify({ actionName, payload, storedAt: Date.now() }),
    );

    openModal("user-login");
}

/**
 * موقع لود شدن هر صفحه (از app.js) صدا زده میشه. اگه فرم یا اکشنی از
 * قبل معلق مونده بود و کاربر الان لاگینه، خودش دوباره انجامش میده.
 */
export function resumePendingAuthAction() {
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

function readAndClear(key) {
    const raw = sessionStorage.getItem(key);
    if (!raw) return null;

    sessionStorage.removeItem(key);

    let data;
    try {
        data = JSON.parse(raw);
    } catch {
        return null;
    }

    if (!data.storedAt || Date.now() - data.storedAt > EXPIRY_MS) {
        return null; // خیلی قدیمی شده، نادیده بگیر
    }

    return data;
}

function resumeForm({ formId, values }) {
    const form = document.getElementById(formId);
    if (!form) return;

    Object.entries(values).forEach(([name, value]) => {
        const field = form.querySelector(`[name="${name}"]`);
        if (field) field.value = value;
    });

    form.submit();
}
