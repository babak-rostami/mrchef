<?php

namespace App\Services\ckeditor\strategies;

use App\Models\Category;
use App\Services\ckeditor\interfaces\EditorProcessorInterface;

class CategoryEditorProcessor implements EditorProcessorInterface
{
    public function getImagePathsInEditor($imageTags)
    {
        $imagePaths = [];
        foreach ($imageTags as $imageTag) {
            $image_src = $imageTag->getAttribute('src');
            $path = explode(Category::EDITOR_PATH, $image_src);

            if (isset($path[1])) {
                $image_full_path = Category::EDITOR_PATH . $path[1];
                $imagePaths[] = $image_full_path;
            }
        }
        return $imagePaths;
    }
}
