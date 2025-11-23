<?php

namespace App\Models;

use App\Services\ImageService;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Imageable, HasFactory;

    const STORE_IMAGE_PATH = 'ingredient';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($recipe) {

            $imageService = resolve(ImageService::class);

            // حذف عکس اصلی
            if ($recipe->image) {
                $imageService->delete($recipe->image);
            }
        });
    }

    protected $fillable = ['name', 'name_en', 'slug', 'image', 'show_in_search'];
}
