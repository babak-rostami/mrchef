# سیستم کامنت (Comment System)

این سند دقیقاً توضیح میده این بخش از سایت از چه فایل‌هایی ساخته شده، چطور
کار می‌کنه، و دو سناریو رو پوشش می‌ده:

- **افزودن کامنت به یه مدل جدید توی همین پروژه** (مثلاً محصولات)
- **کپی کل سیستم به یه پروژه‌ی لاراول دیگه**

---

## ۱) اصل طراحی، خیلی خلاصه

- **پلی‌مورفیک ولی مسطح.** کامنت‌های اصلی با `commentable_id`/`commentable_type`
  به هر مدلی (رسپی، محصول، ...) وصل می‌شن. اما پاسخ‌ها (حتی پاسخ به پاسخ)
  اصلاً `commentable_*` ندارن — همه‌شون مستقیم زیر همون کامنت اصلی با
  `parent_id` قرار می‌گیرن. `reply_id` دقیقاً مشخص می‌کنه کدوم پاسخ جواب
  داده شده (برای نمایش «پاسخ به فلانی»).
- **یه منبع حقیقت برای ظاهر هر کامنت.** فایل
  `resources/views/components/comment/item/show.blade.php` تنها جایی‌ه
  که تعیین می‌کنه یه کامنت/پاسخ چه شکلیه. چه لود اولیه‌ی صفحه (سرور
  رندرش می‌کنه)، چه اضافه‌شدن با AJAX (کنترلر همین Blade partial رو
  رندر می‌کنه و HTML آماده برمی‌گردونه) — همیشه از همین یه فایل میاد.
  هیچ‌وقت لازم نیست ظاهر کامنت رو توی جاوااسکریپت هم جداگونه بسازی.
- **هیچ‌جا اسم مدل خاصی (مثل «رسپی») قفل نشده.** همه‌چیز از روی دو
  پارامتر جنریک میره: `page` (یه اسم رشته‌ای دلخواه، مثل `'recipe'`) و
  `object_id`. تنها جایی که این اسم‌ها به یه مدل واقعی وصل می‌شن، متد
  `CommentService::getModelByPage()`ه.

---

## ۲) فهرست کامل فایل‌ها

### دیتابیس

| فایل | کارش |
|---|---|
| `database/migrations/..._create_comments_table.php` | جدول `comments` |
| `database/migrations/..._create_comment_reactions_table.php` | جدول `comment_reactions` (لایک/دیس‌لایک) |

ستون‌های کلیدی جدول `comments`: `commentable_id`, `commentable_type`,
`user_id`, `parent_id`, `reply_id`, `body`, `reply_count`, `like_count`,
`dislike_count`, `created_at`, `updated_at`.

### مدل‌ها

| فایل | کارش |
|---|---|
| `app/Models/Comment.php` | مدل اصلی. رابطه‌ها (`user`, `parent`, `replyTo`, `replies`, `repliesForDisplay`, `reactions`)، `isReply()`، ثابت `PER_PAGE` |
| `app/Models/CommentReaction.php` | مدل لایک/دیس‌لایک |

### سرویس (تنها جایی که منطق واقعیه)

| فایل | کارش |
|---|---|
| `app/Services/comment/CommentService.php` | ساخت کامنت/پاسخ، گرفتن کامنت‌های صفحه‌بندی‌شده. **تنها جایی که مدل‌های commentable معرفی می‌شن.** |

### کنترلرها

| فایل | کارش |
|---|---|
| `app/Http/Controllers/Frontend/CommentController.php` | `store` (ثبت AJAX)، `showReplies` (لود پاسخ‌ها)، `loadMore` (دکمه‌ی نظرات بیشتر) — فقط تبدیل درخواست HTTP به فراخوانی `CommentService`، بدون منطق اضافه |
| `app/Http/Controllers/Frontend/CommentReactionController.php` | `toggle` لایک/دیس‌لایک؛ هم برای مهمون هم کاربر لاگین‌شده کار می‌کنه |

### ولیدیشن

| فایل | کارش |
|---|---|
| `app/Http/Requests/comment/StoreRequest.php` | ولیدیشن ثبت کامنت/پاسخ |

### روت‌ها (`routes/web.php`)

```php
// عمومی — بدون نیاز به لاگین
Route::get('show-comment-replies/{comment}', [CommentController::class, 'showReplies']);
Route::get('load-more-comments', [CommentController::class, 'loadMore']);
Route::post('comments/{comment}/reaction', [CommentReactionController::class, 'toggle']);

// نیاز به لاگین
Route::middleware('auth')->group(function () {
    Route::post('comment-store', [CommentController::class, 'store'])->name('comment.store');
});
```

### Blade

| فایل | کارش |
|---|---|
| `resources/views/components/comment/section.blade.php` | **نقطه‌ی ورود.** همینو توی صفحه‌ای که کامنت لازم داره صدا بزن. |
| `resources/views/components/comment/form.blade.php` | فرم ثبت کامنت اصلی |
| `resources/views/components/comment/reply/form.blade.php` | فرم ثبت پاسخ (داخل مودال) |
| `resources/views/components/comment/reply/modal.blade.php` | مودال ریپلای |
| `resources/views/components/comment/item/show.blade.php` | ⭐ تنها جایی که ظاهر یه کامنت/پاسخ تعریف میشه |
| `resources/views/components/comment/item/replies-toggle.blade.php` | دکمه‌ی «نمایش N پاسخ» + باکس پاسخ‌ها (جدا شده تا سرور بتونه موقع اولین پاسخ، تازه بسازتش) |
| `resources/views/components/comment/item/user.blade.php` | عکس/نام/یوزرنیم نویسنده‌ی کامنت |
| `resources/views/components/comment/item/action/reaction.blade.php` | دکمه‌های لایک/دیس‌لایک |
| `resources/views/components/comment/item/action/reply.blade.php` | دکمه‌ی «پاسخ» (بازکننده‌ی مودال ریپلای) |

### جاوااسکریپت

| فایل | کارش |
|---|---|
| `resources/js/component/comment/index.js` | نقطه‌ی ورود. `sendComment`، ثبت AJAX، اضافه‌کردن کامنت/پاسخ تازه به لیست، مدیریت خطا/دکمه |
| `resources/js/component/comment/dom.js` | `htmlToElement`، `scrollToAndHighlight` — کاملاً عمومی، مخصوص کامنت نیستن |
| `resources/js/component/comment/validation/body.js` | اعتبارسنجی سمت کلاینت متن کامنت (خالی نباشه) |
| `resources/js/component/comment/action/reply.js` | باز کردن مودال ریپلای و پر کردن `comment_id` مخفی |
| `resources/js/component/comment/action/reaction.js` | کلیک لایک/دیس‌لایک |
| `resources/js/component/comment/action/show-replies.js` | `loadReplies` (گرفتن پاسخ‌ها از سرور، فقط یک‌بار) + دکمه‌ی باز/بسته |
| `resources/js/component/comment/action/load-more.js` | دکمه‌ی «نمایش نظرات بیشتر» |
| `resources/js/component/comment/action/modal.js` | `openBComReplyModal`/`closeBComReplyModal` — اگه این مسیر توی پروژه‌ت فرق داشت، دنبال تابع `openBComReplyModal` بگرد |

### CSS

| فایل | کارش |
|---|---|
| `resources/css/component/comment/index.css` | استایل و انیمیشن‌ها (بانس لایک/دیس‌لایک، هایلایت نظر تازه، پالس دکمه‌ی نظرات بیشتر) |

### وابستگی‌ها (جزو سیستم کامنت نیستن، ولی لازمشونه)

| چی | برای چی لازمه |
|---|---|
| `resources/js/utils/require-login.js` | قبل از ثبت کامنت/پاسخ، اگه کاربر لاگین نباشه مودال لاگین باز میشه. توضیح کامل: `docs/require-login-system.md` |
| `resources/js/component/modal.js` | سیستم عمومی باز/بسته‌کردن مودال سایت (برای مودال ریپلای و لاگین) |
| `axios` (به‌صورت `window.axios`، توی `bootstrap.js`) | همه‌ی درخواست‌های AJAX این بخش |
| پکیج `morilog/jalali` (`composer require morilog/jalali`) | `Comment::getCreatedAtAttribute()` از `jdate()` استفاده می‌کنه تا زمان کامنت فارسی و نسبی نشون داده بشه (مثلاً «۲ ساعت پیش») |
| Tailwind با Preflight فعال | لیست‌های `<ul>`/`<li>` توی این بخش به ریست‌شدن استایل پیش‌فرض لیست وابسته‌ن |

اگه نمی‌خوای وابستگی به `require-login.js` داشته باشی (مثلاً یه پروژه‌ای
که همیشه صفحات کامنت‌دارش فقط برای کاربر لاگین‌شده‌ست)، کافیه توی
`index.js` خط `requireLoginForForm(...)` رو با فراخوانی مستقیم
`submitCommentForm(form, section)` عوض کنی.

---

## ۳) اضافه کردن کامنت به یه مدل جدید (همین پروژه)

فرض کن می‌خوای مدل `Product` هم کامنت‌پذیر بشه.

**۱. رابطه‌ی جنریک رو به مدل اضافه کن** (دقیقاً همین که `Recipe` داره):

```php
// app/Models/Product.php
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Comment;

public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}
```

**۲. یه خط توی `CommentService::getModelByPage()` اضافه کن:**

```php
private function getModelByPage(string $page, int $id): Model
{
    return match ($page) {
        'recipe' => Recipe::findOrFail($id),
        'product' => Product::findOrFail($id), // همین یه خط
        default => throw new InvalidArgumentException("کامنت برای صفحه‌ی «{$page}» پشتیبانی نمیشه."),
    };
}
```

**۳. توی `ProductController` (یا هر کنترلری که صفحه‌ی نمایش محصول رو رندر
می‌کنه)، دقیقاً همون الگوی `RecipeController::show()` رو تکرار کن:**

```php
public function __construct(private CommentService $commentService) {}

public function show(Product $product): View
{
    [$comments, $hasMoreComments] = $this->commentService->getTopLevelComments('product', $product->id);

    return view('frontend.products.show', compact('product', 'comments', 'hasMoreComments'));
}
```

**۴. توی ویوی محصول، کامپوننت رو صدا بزن:**

```blade
<x-comment.section page="product" :object="$product" :comments="$comments" :has_more_comments="$hasMoreComments" />
```

همین. هیچ کنترلر، جاوااسکریپت یا Blade دیگه‌ای لازم نیست دست بخوره —
هر چهار مورد بالا کل تغییریه که لازمه.

---

## ۴) کپی کردن کل سیستم به یه پروژه‌ی لاراول دیگه

۱. دو تا migration بخش دیتابیس رو کپی کن و `php artisan migrate` بزن.
۲. همه‌ی فایل‌های جدول بخش ۲ (بک‌اند، Blade، جاوااسکریپت، CSS) رو با
   همین مسیرهای نسبی کپی کن.
۳. `composer require morilog/jalali` (یا اگه تاریخ فارسی نمی‌خوای، توی
   `Comment::getCreatedAtAttribute()` خط `jdate($value)->ago()` رو با
   `\Carbon\Carbon::parse($value)->diffForHumans()` عوض کن).
۴. روت‌های بخش ۲ رو به `routes/web.php` اضافه کن.
۵. مطمئن شو `axios` global هست (`window.axios = axios;` توی
   `resources/js/bootstrap.js`، و `app.js` این فایل رو ایمپورت می‌کنه).
۶. یه سیستم مودال عمومی با همین قرارداد داشته باش: `window.openModal(id)`
   و `window.closeModal(id)`، به‌علاوه‌ی این‌که `closeModal` یه
   `CustomEvent('modal:closed', { detail: { id } })` پخش کنه (این آخری
   فقط اگه از `require-login.js` هم استفاده می‌کنی لازمه).
۷. اگه از سیستم لاگین‌اجباری استفاده نمی‌کنی، خط `requireLoginForForm`
   توی `index.js` رو حذف کن (بخش «وابستگی‌ها» بالا رو ببین).
۸. Tailwind با Preflight فعال داشته باش (پیش‌فرض خود Tailwinde).
۹. به هر مدلی که کامنت لازم داره، رابطه‌ی `comments(): MorphMany` بده و
   توی `CommentService::getModelByPage()` معرفیش کن (دقیقاً مثل بخش ۳).
۱۰. توی ویوی مربوطه: `<x-comment.section page="..." :object="$model" :comments="$comments" :has_more_comments="$hasMore" />`

---

## ۵) نقطه‌ی تنظیم (Configuration)

- **`Comment::PER_PAGE`** (توی `app/Models/Comment.php`) — چند تا کامنت
  اصلی در هر بار نمایش داده بشه؛ هم موقع لود اولیه‌ی صفحه، هم هر بار که
  دکمه‌ی «نمایش نظرات بیشتر» زده میشه. همین یه عدد رو عوض کن، همه‌جا
  خودش رو تطبیق می‌ده.
- رنگ/انیمیشن‌ها توی `resources/css/component/comment/index.css`، بدون
  این‌که به هیچ منطقی دست بزنی قابل تغییرن.

---

## ۶) رفتارها و محدودیت‌های شناخته‌شده

- **ساختار پاسخ‌ها مسطحه.** هر چقدر هم که یه زنجیره‌ی «پاسخ به پاسخِ
  پاسخ» عمیق بشه، همه‌شون مستقیم زیر همون کامنت اصلی ذخیره می‌شن
  (`parent_id`)؛ فقط `reply_id` مشخص می‌کنه دقیقاً به کدوم پاسخ جواب
  داده شده، برای نمایش «پاسخ به فلانی».
- **کامنت‌ها از جدید به قدیم نمایش داده می‌شن**؛ کامنت تازه همیشه اول
  لیست میاد. **پاسخ‌ها برعکس، از قدیم به جدید هستن** و پاسخ تازه همیشه
  ته لیست پاسخ‌ها میره — این تفاوت عمدیه، جای دیگه‌ای عوضش نکن.
- فعلاً ویرایش یا حذف کامنت وجود نداره.
- لایک/دیس‌لایک هم برای مهمون کار می‌کنه (با شناسه‌ی نشست/session) هم
  کاربر لاگین‌شده؛ عمداً پشت گیت لاگین نیست. فقط **ثبت خودِ کامنت/پاسخ**
  نیاز به لاگین داره.
