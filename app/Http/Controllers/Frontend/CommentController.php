<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\comment\StoreRequest;
use App\Models\Comment;
use App\Models\Recipe;
use App\Services\comment\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(StoreRequest $request)
    {
        $request->validated();

        if ($request->comment_id) {
            $this->commentService->storeReply($request);
        } else {
            $this->commentService->storeComment($request);
        }
        return back()->with('success', 'نظر شما با موفقیت ثبت شد.');
    }

    public function showReplies(Comment $comment)
    {
        $replies = $comment->repliesForJson;

        return response()->json([
            'replies' => $replies
        ], 200);
    }

}
