<?php

namespace App\Services\ckeditor\strategies;

use App\Models\Comment;
use App\Services\ckeditor\interfaces\EditorProcessorInterface;

class CommentEditorProcessor implements EditorProcessorInterface
{
    public function getImagePathsInEditor($imageTags)
    {
        $imagePaths = [];
        foreach ($imageTags as $imageTag) {
            $image_src = $imageTag->getAttribute('src');
            $path = explode(Comment::EDITOR_PATH, $image_src);

            if (isset($path[1])) {
                $image_full_path = Comment::EDITOR_PATH . $path[1];
                $imagePaths[] = $image_full_path;
            }
        }
        return $imagePaths;
    }
}
