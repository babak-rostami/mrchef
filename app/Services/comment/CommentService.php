<?php

namespace App\Services\comment;

use App\Http\Requests\comment\StoreRequest;
use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function storeComment(StoreRequest $request)
    {
        $model = $this->getModelByPage($request->object_page, $request->object_id);

        $data = [
            'user_id' => Auth::id(),
            'body' => $request->body,
        ];

        $model->comments()->create($data);
    }

    public function storeReply(StoreRequest $request)
    {
        $data = [
            'user_id' => Auth::id(),
            'body' => $request->body
        ];
        $parent_comment = Comment::findOrFail($request->comment_id);
        if ($parent_comment->parent_id) {
            $this->updateParentReplyCount($parent_comment->parent_id);
            $data['parent_id'] = $parent_comment->parent_id;
            $data['reply_id'] = $parent_comment->id;
        } else {
            $this->updateParentReplyCount($parent_comment->id);
            $data['parent_id'] = $parent_comment->id;
        }

        Comment::create($data);
    }


    //------------------------------------------------------------------------------------
    //------------------------------private functions-------------------------------------
    //------------------------------------------------------------------------------------
    private function getModelByPage($page, $id)
    {
        if ($page === 'recipe') {
            return Recipe::find($id);
        }
    }

    private function updateParentReplyCount($parent_comment_id)
    {
        //no race condition
        Comment::where('id', $parent_comment_id)->increment('reply_count');
    }
}
