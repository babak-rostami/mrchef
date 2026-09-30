<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\comment\StoreRequest;
use App\Models\Comment;
use App\Services\comment\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService) {}

    /**
     * ثبت یه کامنت اصلی یا یه پاسخ، به‌صورت AJAX.
     * به‌جای ریدایرکت، همیشه JSON برمی‌گردونه شامل HTML آماده‌ی رندرشده‌ی
     * خودِ کامنت/پاسخ — این‌جوری قالب کامنت فقط توی بلید یه جا تعریف میشه
     * (هم برای رندر اولیه، هم برای اضافه‌ی AJAX)، نه دوبار.
     */
    public function store(StoreRequest $request)
    {
        if ($request->comment_id) {
            $reply = $this->commentService->storeReply($request);
            $parent = Comment::find($reply->parent_id);

            return response()->json([
                'success' => true,
                'is_reply' => true,
                'parent_id' => $reply->parent_id,
                'html' => view('components.comment.item.show', ['comment' => $reply])->render(),
                // اگه این اولین پاسخ این کامنت باشه، دکمه‌ی «نمایش پاسخ‌ها» هنوز
                // توی صفحه نیست؛ این HTML همونیه که باید تازه ساخته بشه.
                'toggle_html' => $parent
                    ? view('components.comment.item.replies-toggle', ['comment' => $parent])->render()
                    : null,
            ]);
        }

        $comment = $this->commentService->storeComment($request);

        return response()->json([
            'success' => true,
            'is_reply' => false,
            'html' => view('components.comment.item.show', ['comment' => $comment])->render(),
        ]);
    }

    public function showReplies(Comment $comment)
    {
        $html = $comment->repliesForDisplay
            ->map(fn($reply) => view('components.comment.item.show', ['comment' => $reply])->render())
            ->implode('');

        return response()->json(['html' => $html]);
    }

    /**
     * دکمه‌ی «نمایش نظرات بیشتر». page/object_id/offset رو از همون
     * data-attributeهایی که section.blade.php روی #comments-box گذاشته میگیره.
     */
    public function loadMore(Request $request)
    {
        $request->validate([
            'page' => ['required', 'string'],
            'object_id' => ['required', 'integer'],
            'offset' => ['required', 'integer', 'min:0'],
        ]);

        [$comments, $hasMore] = $this->commentService->getTopLevelComments(
            $request->input('page'),
            (int) $request->input('object_id'),
            (int) $request->input('offset')
        );

        $html = $comments
            ->map(fn($comment) => view('components.comment.item.show', ['comment' => $comment])->render())
            ->implode('');

        return response()->json([
            'html' => $html,
            'count' => $comments->count(),
            'has_more' => $hasMore,
        ]);
    }
}
