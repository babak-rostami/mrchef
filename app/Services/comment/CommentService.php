<?php

namespace App\Services\comment;

use App\Http\Requests\comment\StoreRequest;
use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class CommentService
{
    public function storeComment(StoreRequest $request): Comment
    {
        $model = $this->getModelByPage($request->object_page, $request->object_id);

        $comment = $model->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return $comment->load('user');
    }

    public function storeReply(StoreRequest $request): Comment
    {
        $parentComment = Comment::findOrFail($request->comment_id);

        $data = [
            'user_id' => Auth::id(),
            'body' => $request->body,
        ];

        if ($parentComment->parent_id) {
            // داره به یه پاسخِ دیگه جواب میده: parent_id همون کامنت اصلیه
            // (ساختار همیشه مسطحه)، reply_id همون پاسخیه که الان جوابش داده میشه.
            $data['parent_id'] = $parentComment->parent_id;
            $data['reply_id'] = $parentComment->id;
        } else {
            // داره مستقیم به کامنت اصلی جواب میده.
            $data['parent_id'] = $parentComment->id;
        }

        $reply = Comment::create($data);

        $this->incrementReplyCount($data['parent_id']);

        return $reply->load(['user', 'replyTo.user']);
    }

    /**
     * کامنت‌های اصلیِ (نه پاسخ‌ها) یه commentable رو صفحه‌بندی‌شده و از
     * جدید به قدیم برمی‌گردونه. هم برای لود اولیه‌ی صفحه استفاده میشه،
     * هم برای دکمه‌ی «نمایش نظرات بیشتر» — هر بار offset رو با تعداد
     * کامنت‌های قبلاً لودشده پر کن.
     *
     * @return array{0: \Illuminate\Database\Eloquent\Collection<int, Comment>, 1: bool}
     *         [کامنت‌های این صفحه, آیا کامنت بیشتری هم هست]
     */
    public function getTopLevelComments(string $page, int $objectId, int $offset = 0): array
    {
        $model = $this->getModelByPage($page, $objectId);

        $comments = $model->comments()
            ->whereNull('parent_id')
            ->with('user:id,name,username,image')
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit(Comment::PER_PAGE + 1)
            ->get();

        $hasMore = $comments->count() > Comment::PER_PAGE;

        return [$comments->take(Comment::PER_PAGE), $hasMore];
    }

    /**
     * مدل commentable رو از روی اسم صفحه پیدا می‌کنه.
     * برای اضافه کردن کامنت به یه بخش جدید (مثلاً محصولات)، فقط یه خط
     * اینجا اضافه کن — کنترلر، جاوااسکریپت و بلید دست‌نخورده می‌مونن.
     */
    private function getModelByPage(string $page, int $id): Model
    {
        return match ($page) {
            'recipe' => Recipe::findOrFail($id),
            default => throw new InvalidArgumentException("کامنت برای صفحه‌ی «{$page}» پشتیبانی نمیشه."),
        };
    }

    private function incrementReplyCount(int $parentCommentId): void
    {
        // no race condition
        Comment::where('id', $parentCommentId)->increment('reply_count');
    }
}
