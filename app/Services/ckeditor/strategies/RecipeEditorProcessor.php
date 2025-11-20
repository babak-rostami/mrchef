<?php

namespace App\Services\ckeditor\strategies;

use App\Models\Recipe;
use App\Services\ckeditor\interfaces\EditorProcessorInterface;

class RecipeEditorProcessor implements EditorProcessorInterface
{
    public function getImagePathsInEditor($imageTags)
    {
        $imagePaths = [];
        foreach ($imageTags as $imageTag) {
            $image_src = $imageTag->getAttribute('src');
            $path = explode(Recipe::EDITOR_PATH, $image_src);

            if (isset($path[1])) {
                $image_full_path = Recipe::EDITOR_PATH . $path[1];
                $imagePaths[] = $image_full_path;
            }
        }
        return $imagePaths;
    }
}
