<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function __construct(private CkeditorService $editorService, private ImageUploadService $images) {}

    public function created(Category $category): void
    {
        $this->editorService->store(Category::EDITOR_KEY, $category);
        $this->forgetCache();
    }

    public function updated(Category $category): void
    {
        $this->editorService->update(Category::EDITOR_KEY, $category);
        $this->forgetCache();
    }

    public function deleting(Category $category): void
    {
        if ($category->image) {
            $this->images->delete($category->image_path);
            $this->images->delete($category->thumb_path);
        }

        foreach ($category->editorImages as $editorImage) {
            $this->images->delete($editorImage->image_path);
            $editorImage->delete();
        }

        $this->forgetCache();
    }

    public function restored(Category $category): void
    {
        //
    }

    public function forceDeleted(Category $category): void
    {
        //
    }

    private function forgetCache(): void
    {
        Cache::forget('categories');
        // چون سایت‌مپ صفحات، لیست دسته‌بندی‌ها رو داره، با تغییر دسته‌بندی باید کشش پاک بشه
        Cache::forget('sitemap:pages');
    }
}
