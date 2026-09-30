<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    /**
     * چند تا کامنت اصلی (نه پاسخ) در هر بار نمایش داده بشه — هم موقع لود
     * اولیه‌ی صفحه، هم هر بار که دکمه‌ی «نمایش نظرات بیشتر» زده میشه.
     * برای تغییر تعداد، فقط همین عدد رو عوض کن؛ همه‌جا از همین میخونن.
     * @see \App\Services\comment\CommentService::getTopLevelComments()
     */
    public const PER_PAGE = 20;

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'parent_id',
        'reply_id',
        'body',
    ];

    /**
     * مقدار پیش‌فرض شمارنده‌ها روی خود مدل (نه فقط توی دیتابیس).
     * چرا؟ Eloquent بعد از create() ردیف رو دوباره از دیتابیس نمی‌خونه؛
     * پس اگه این‌ها اینجا تعریف نشن، مدلِ تازه‌ساخته توی PHP مقدار
     * like_count/dislike_count نداره و بلید به‌جای «0» یه جای خالی چاپ می‌کنه.
     * عمداً توی $fillable نیستن: شمارنده‌ها فقط با کد (increment) عوض میشن،
     * نه با mass assignment.
     */
    protected $attributes = [
        'like_count' => 0,
        'dislike_count' => 0,
        'reply_count' => 0,
    ];

    public function getCreatedAtAttribute($value)
    {
        return jdate($value)->ago();
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * والدِ مستقیم — برای پاسخ‌ها همیشه همون کامنت اصلیه (ساختار مسطح).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * دقیقاً کدوم کامنت/پاسخ جواب داده شده — برای نمایش «پاسخ به فلانی».
     * فرقش با parent: parent همیشه کامنت اصلیه، replyTo همون چیزیه که
     * واقعاً بهش جواب داده شده (ممکنه یه پاسخ دیگه باشه، نه کامنت اصلی).
     */
    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'reply_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * پاسخ‌های آماده‌ی نمایش (برای رندر شدن به HTML)، از قدیم به جدید،
     * همراه کاربرشون و کاربرِ کسی که جوابش داده شده (برای «پاسخ به فلانی»).
     */
    public function repliesForDisplay(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->with(['user:id,name,username,image', 'replyTo.user:id,name,username,image'])
            ->orderBy('created_at');
    }

    public function isReply(): bool
    {
        return ! is_null($this->parent_id);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(CommentReaction::class);
    }
}
