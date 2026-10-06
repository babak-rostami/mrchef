<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\comment\UpdateRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user:id,name,username')
            ->latest()
            ->get();

        return view('admin.comment.index', compact('comments'));
    }

    public function edit(Comment $comment)
    {
        return view('admin.comment.edit', compact('comment'));
    }

    public function update(UpdateRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return redirect()->route('admin.comments.index')->with('success', 'نظر با موفقیت ویرایش شد');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'نظر با موفقیت حذف شد');
    }
}
