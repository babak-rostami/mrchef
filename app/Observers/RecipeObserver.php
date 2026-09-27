<?php

namespace App\Observers;

use App\Models\Recipe;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Cache;

class RecipeObserver
{
    public function __construct(private CkeditorService $editorService, private ImageUploadService $images) {}

    public function created(Recipe $recipe): void
    {
        $this->editorService->store(Recipe::EDITOR_KEY, $recipe);
        $this->forgetSitemapCache($recipe);
    }

    public function updated(Recipe $recipe): void
    {
        $this->editorService->update(Recipe::EDITOR_KEY, $recipe);
        $this->forgetSitemapCache($recipe);
    }

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

        $this->forgetSitemapCache($recipe);
    }

    public function restored(Recipe $recipe): void
    {
        //
    }

    public function forceDeleted(Recipe $recipe): void
    {
        //
    }

    /**
     * سایت‌مپ رسپی‌ها بر اساس id تکه‌تکه (chunk) شده و هر چانک برای مدت
     * طولانی کش می‌شه (نگاه کن به SitemapController). با هر تغییر روی یک
     * رسپی، فقط کش همون یک چانک پاک می‌شه، نه بقیه‌ی چانک‌های قدیمی.
     */
    private function forgetSitemapCache(Recipe $recipe): void
    {
        Cache::forget("sitemap:recipes:{$recipe->sitemap_chunk}");
        Cache::forget('sitemap:index');
    }
}
