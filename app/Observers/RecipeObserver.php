<?php

namespace App\Observers;

use App\Models\Recipe;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageUploadService;

class RecipeObserver
{
    public function __construct(private CkeditorService $editorService, private ImageUploadService $images) {}

    /**
     * Handle the Recipe "created" event.
     */
    public function created(Recipe $recipe): void
    {
        $this->editorService->store(Recipe::EDITOR_KEY, $recipe);
    }

    /**
     * Handle the Recipe "updated" event.
     */
    public function updated(Recipe $recipe): void
    {
        $this->editorService->update(Recipe::EDITOR_KEY, $recipe);
    }

    /**
     * Handle the Recipe "deleting" event.
     */
    public function deleting(Recipe $recipe): void
    {
        if ($recipe->image) {
            $this->images->delete($recipe->image_path);
            $this->images->delete($recipe->thumb_path);
        }

        foreach ($recipe->editorImages as $editorImage) {
            $this->images->delete($editorImage->image_path);
            $editorImage->delete();
        }
    }

    /**
     * Handle the Recipe "restored" event.
     */
    public function restored(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "force deleted" event.
     */
    public function forceDeleted(Recipe $recipe): void
    {
        //
    }
}
