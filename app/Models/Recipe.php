<?php

namespace App\Models;

use App\Services\ImageService;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use Imageable, HasFactory;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_PENDING = 2;
    const EDITOR_PATH = 'recipe/editor/1';
    const EDITOR_KEY = 'recipe';
    const STORE_IMAGE_PATH = 'recipe';

    protected $fillable = ['category_id', 'user_id', 'title', 'slug', 'description', 'body', 'status', 'image', 'time_prepare', 'time_cook', 'servings'];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($recipe) {

            $recipe->load(['editorImages']);

            $imageService = resolve(ImageService::class);

            // حذف عکس اصلی
            if ($recipe->image) {
                $imageService->delete($recipe->image);
            }

            // حذف تصاویر CKEditor
            foreach ($recipe->editorImages as $editorImage) {
                $imageService->delete($editorImage->image);
                $editorImage->delete();
            }
        });
    }

    public function editorImages()
    {
        return $this->morphMany(CkeditorImage::class, 'editorable');
    }
}
