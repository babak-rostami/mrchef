# سیستم لاگین اجباری (Require Login)

این سند توضیح می‌ده این بخش چطور کار می‌کنه، چه فایل‌هایی داره، و با دو
مثال کامل نشون می‌ده چطور برای یه کار جدید (فرمی یا غیر-فرمی) ازش
استفاده کنی.

---

## ۱) مسئله‌ای که حل می‌کنه

بدون این سیستم: کاربر مهمون یه کاری می‌خواد بکنه (نظر بذاره، لایک کنه،
...) → روت سمت سرور پشت `auth` هست → کاربر به یه **صفحه‌ی جدای لاگین**
هدایت می‌شه → هر چیزی که تایپ/انتخاب کرده بود از دست می‌ره → باید
دوباره از اول شروع کنه.

با این سیستم: کلیک روی دکمه → اگه مهمونه، **همون‌جا** یه مودال لاگین
باز می‌شه (بدون رفتن به صفحه‌ی دیگه) → کاربر لاگین/ثبت‌نام می‌کنه →
همون کاری که اول می‌خواست بکنه **خودش خودکار انجام می‌شه** — بدون
این‌که چیزی تایپ‌شده گم بشه.

---

## ۲) فایل‌ها

| فایل | کارش |
|---|---|
| `resources/js/utils/require-login.js` | **کل منطق همینجاست.** `requireLoginForForm`، `requireLogin`، `registerAction`، `resumePendingAuthAction` |
| `resources/js/component/modal.js` | سیستم عمومی مودال سایت. لازمه چون: (الف) این ماژول با `openModal('user-login')` مودال لاگین رو باز می‌کنه، (ب) با پخش کردن ایونت `modal:closed` وقتی هر مودالی بسته می‌شه، به این ماژول اجازه می‌ده بفهمه مودال لاگین بدون لاگین موفق بسته شده |
| `resources/js/app.js` | فقط یه خط: `resumePendingAuthAction` رو روی `pageshow` صدا می‌زنه — این خطیه که باعث میشه بعد از رفرش شدن صفحه (بعد از لاگین موفق)، کار معلق خودش ادامه پیدا کنه |
| مودال با `id="user-login"` (توی این پروژه: `user.auth-modal.index` که `@guest` رندر میشه) | خودِ فرم لاگین/ثبت‌نام. باید همیشه، توی هر صفحه‌ای که ممکنه این سیستم رو صدا بزنی، در دسترس باشه |
| `login.js` / `register.js` | این‌ها **دست نخوردن** و همون‌طوری که بودن کار می‌کنن — فقط باید بعد از موفقیت `window.location.reload()` بزنن (که از قبل می‌زنن). همین رفرش‌شدن دوباره‌ست که `resumePendingAuthAction` رو صدا می‌زنه |

هیچ فایل Laravel‌ای لازم نیست؛ کل قضیه سمت کلاینته. تنها الزام سمت
سرور اینه که روتی که قراره اجرا بشه واقعاً پشت میدل‌ور `auth` باشه —
این سیستم فقط UX رو درست می‌کنه، جای چک امنیتی سرور رو نمی‌گیره.

---

## ۳) دو تا ابزار، دو تا کاربرد

### الف) `requireLoginForForm` — برای فرم‌ها

وقتی کاری که می‌خوای انجام بشه، نتیجه‌ی submit شدن یه `<form>`ه (مهم
نیست AJAX باشه یا نه).

```js
import { requireLoginForForm } from '../../utils/require-login';

requireLoginForForm(
    formElement,     // خودِ <form>
    onReady,         // تابعی که وقتی کاربر لاگینه (الان یا بعد از resume) اجرا میشه
    resume           // اختیاری — پایین توضیح داده شده
);
```

**پارامتر سوم (`resume`) رو کِی بدی، کِی ندی:**

- **فرم AJAX (مثل ثبت کامنت):** حتماً بده. چون بعد از رفرش صفحه، دیگه
  نمی‌شه یه closure جاوااسکریپتی (تابع `onReady`) رو نگه داشت — باید از
  اول همون تابع global که کاربر اولین بار صداش زده بود رو دوباره صدا
  بزنی:
  ```js
  { fn: 'اسم یه تابع global', args: [آرگومان‌هایی که اون تابع نیاز داره] }
  ```
- **فرم عادی (non-AJAX، submit واقعی مرورگر):** ندش (یا `null` بذار).
  پیش‌فرض بعد از لاگین، خودِ فرم `form.submit()` می‌شه — که برای یه
  فرم عادی همون رفتاریه که می‌خوای.

### ب) `requireLogin` + `registerAction` — برای کارهای غیر-فرمی

وقتی کاری که می‌خوای انجام بشه، submit یه فرم نیست — مثلاً کلیک روی
یه دکمه که فقط یه `axios.post` می‌زنه.

```js
import { registerAction, requireLogin } from '../../utils/require-login';

// این باید موقع لود شدن فایل صدا زده بشه، نه موقع کلیک — چون بعد از
// رفرش صفحه، جاوااسکریپت از اول اجرا میشه و باید بدونه این اسم به
// کدوم تابع وصله.
registerAction('اسم-دلخواه-اکشن', (payload) => {
    // کاری که واقعاً باید انجام بشه
});

// بعداً، هر جا که کاربر کلیک کرد:
requireLogin('اسم-دلخواه-اکشن', { هر داده‌ای که handler بالا لازم داره });
```

---

## ۴) مثال کامل ۱: یه فرم AJAX جدید (مثل کامنت)

فرض کن می‌خوای یه فرم «ثبت نظر برای محصول» بسازی که AJAX باشه.

```js
// resources/js/component/product-review/index.js
import axios from 'axios';
import { requireLoginForForm } from '../../utils/require-login';

function sendProductReview(form_id) {
    const form = document.getElementById(form_id);

    requireLoginForForm(
        form,
        () => submitReview(form),
        { fn: 'sendProductReview', args: [form_id] } // بعد از لاگین، دوباره همین submitReview صدا زده میشه
    );
}

async function submitReview(form) {
    try {
        const response = await axios.post(form.action, new FormData(form));
        // ... نتیجه رو نشون بده
    } catch (error) {
        // ... خطا رو نشون بده
    }
}

window.sendProductReview = sendProductReview; // باید global باشه، چون resume از window صداش می‌زنه
```

```blade
<button onclick="sendProductReview('product-review-form')">ثبت نظر</button>
```

همین. بقیه‌ش (ذخیره‌ی مقادیر فرم، باز کردن مودال لاگین، resume بعد از
رفرش) رو خودِ `requireLoginForForm` انجام می‌ده.

---

## ۵) مثال کامل ۲: یه دکمه‌ی غیر-فرمی (مثلاً «لایک کردن یه رسپی»)

این همون سناریویی‌ه که پرسیدی: یه کار دیگه، بدون فرم، که باید اول
مودال لاگین باز بشه بعد خودِ کار انجام بشه.

**فرض کن یه روت و کنترلر برای لایک‌کردن رسپی داری:**

```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::post('recipes/{recipe}/like', [RecipeLikeController::class, 'toggle']);
});
```

**جاوااسکریپت:**

```js
// resources/js/component/recipe/like.js
import axios from 'axios';
import { registerAction, requireLogin } from '../../utils/require-login';

// ۱. اول اکشن رو ثبت می‌کنیم (موقع لود فایل، نه موقع کلیک)
registerAction('like-recipe', ({ recipeId }) => {
    likeRecipe(recipeId);
});

async function likeRecipe(recipeId) {
    const btn = document.getElementById(`like-recipe-btn-${recipeId}`);
    if (btn) btn.disabled = true;

    try {
        const response = await axios.post(`/recipes/${recipeId}/like`);
        // مثلاً آپدیت کردن تعداد لایک روی صفحه:
        const countEl = document.getElementById(`like-recipe-count-${recipeId}`);
        if (countEl) countEl.textContent = response.data.like_count;
    } finally {
        if (btn) btn.disabled = false;
    }
}

// ۲. موقع کلیک، به‌جای صدا زدن مستقیم likeRecipe، از requireLogin رد میشیم
function onLikeButtonClick(recipeId) {
    requireLogin('like-recipe', { recipeId });
}

window.onLikeButtonClick = onLikeButtonClick;
```

```blade
<button id="like-recipe-btn-{{ $recipe->id }}" onclick="onLikeButtonClick({{ $recipe->id }})">
    <span id="like-recipe-count-{{ $recipe->id }}">{{ $recipe->like_count }}</span>
    لایک
</button>
```

**دقیقاً چه اتفاقی می‌افته:**

1. کاربر مهمون روی دکمه‌ی لایک کلیک می‌کنه.
2. `onLikeButtonClick` → `requireLogin('like-recipe', { recipeId: 5 })` صدا زده میشه.
3. چون مهمونه، `{ actionName: 'like-recipe', payload: { recipeId: 5 } }` توی
   `sessionStorage` ذخیره میشه (همراه آدرس همین صفحه و زمان ذخیره) و
   مودال `user-login` باز میشه.
4. کاربر لاگین می‌کنه → صفحه رفرش میشه.
5. `app.js` روی `pageshow`، `resumePendingAuthAction()` رو صدا می‌زنه.
6. چون الان لاگینه و آدرس صفحه هم یکیه، `actionRegistry['like-recipe']`
   پیدا میشه و با همون `{ recipeId: 5 }` صدا زده میشه — دقیقاً انگار
   کاربر همین الان، بعد از لاگین، خودش روی دکمه کلیک کرده.

اگه کاربر از قبل لاگین بود، مرحله‌های ۳ تا ۵ اصلاً اتفاق نمی‌افتن —
`requireLogin` همون لحظه‌ی اول `handler(payload)` رو صدا می‌زنه.

---

## ۶) نکات مهم

- **حتماً `registerAction` رو موقع لود فایل صدا بزن، نه داخل یه event
  listener یا موقع کلیک.** چون بعد از لاگین و رفرش صفحه، جاوااسکریپت
  کامل از اول اجرا میشه؛ اگه `registerAction` فقط داخل یه تابعی باشه که
  با کلیک اجرا میشه، بعد از رفرش هنوز ثبت نشده و resume شکست می‌خوره.
- **در `requireLoginForForm`، اسم تابعی که به `resume.fn` می‌دی باید
  حتماً `window.اسم_تابع` باشه** (یعنی همون تابعی که با
  `window.اسمش = اسمش;` global شده)، چون بعد از رفرش صفحه فقط از این
  طریق پیدا می‌شه.
- اطلاعات معلق حداکثر ۱۵ دقیقه می‌مونه، فقط برای همون صفحه‌ای که ازش
  شروع شده معتبره، و اگه مودال لاگین بدون لاگین موفق بسته بشه (✕،
  کلیک روی پس‌زمینه، Esc) فوراً پاک میشه — نیازی نیست هیچ‌کدوم از این‌ها
  رو خودت مدیریت کنی.
- این سیستم **امنیتی نیست**، فقط تجربه‌ی کاربریه. روت سمت سرور
  (`recipes/{recipe}/like` توی مثال بالا) باید همیشه پشت `auth`
  بمونه.
