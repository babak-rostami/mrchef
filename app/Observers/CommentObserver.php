<?php

namespace App\Observers;

use App\Models\Comment;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageUploadService;

class CommentObserver
{
    public function __construct(private CkeditorService $editorService, private ImageUploadService $images) {}

    /**
     * عمداً created() نداریم: کامنت‌ها همیشه با body خالی از content
     * ساخته میشن (ثبت اولیه‌ی کاربر، نه ویرایش ادمین)، پس چیزی برای
     * پردازش CKEditor موقع ساخت وجود نداره.
     */
    public function updated(Comment $comment): void
    {
        // فقط وقتی content واقعاً تغییر کرده و خالی نیست لازمه ادیتور رو پردازش کنیم
        if ($comment->wasChanged('content') && $comment->content) {
            $this->editorService->update(Comment::EDITOR_KEY, $comment);
        }
    }

    public function deleting(Comment $comment): void
    {
        foreach ($comment->editorImages as $editorImage) {
            $this->images->delete($editorImage->image_path);
            $editorImage->delete();
        }

        // توجه: اگه این کامنت پاسخ هم داشته باشه، پاسخ‌ها با cascade
        // دیتابیسی حذف میشن (نه از طریق Eloquent)، پس این observer
        // براشون اجرا نمیشه و عکس‌های احتمالی توی content اون پاسخ‌ها
        // پاک نمیشن. با توجه به نادر بودن عکس داخل پاسخ‌ها، فعلاً
        // به همین حد بسنده شده.
    }
}
