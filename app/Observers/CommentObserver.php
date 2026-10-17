<?php

namespace App\Observers;

use App\Models\Comment;
use App\Services\Editor\EditorService;
use App\Services\ImageUploadService;

class CommentObserver
{
    public function __construct(private EditorService $editorService, private ImageUploadService $images) {}

    /**
     * عمداً created() نداریم: کامنت‌ها همیشه با content خالی ساخته میشن
     * (ثبت اولیه‌ی کاربر، نه ویرایش ادمین).
     */
    public function updated(Comment $comment): void
    {
        // پاسخ‌ها اصلاً ادیتور ندارن (فقط body ساده، طبق تصمیم پروژه)
        if ($comment->isReply()) {
            return;
        }

        // فقط وقتی content واقعاً تغییر کرده و خالی نیست لازمه ادیتور رو پردازش کنیم
        if ($comment->wasChanged('content') && $comment->content) {
            $this->editorService->sync($comment, 'content');
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
        // براشون اجرا نمیشه. چون پاسخ‌ها اصلاً content/عکس ندارن
        // (طبق تصمیم این refactor)، این موضوع دیگه مشکلی ایجاد نمی‌کنه.
    }
}
