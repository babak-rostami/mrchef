<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function __construct(private CkeditorService $editorService, private ImageUploadService $images) {}
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->editorService->store(Category::EDITOR_KEY, $category);
        Cache::forget('categories');
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->editorService->update(Category::EDITOR_KEY, $category);
        Cache::forget('categories');
    }

    /**
     * Handle the Category "deleting" event.
     */
    public function deleting(Category $category): void
    {
        // حذف عکس و تامبنیل
        if ($category->image) {
            $this->images->delete($category->image_path);
            $this->images->delete($category->thumb_path);
        }

        // حذف تصاویر CKEditor
        foreach ($category->editorImages as $editorImage) {
            $this->images->delete($editorImage->image_path);
            $editorImage->delete();
        }
        Cache::forget('categories');
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
