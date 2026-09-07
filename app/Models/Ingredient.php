<?php

namespace App\Models;

use App\Services\ImageService;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Imageable, HasFactory;
    public const IMAGE_DIRECTORY = 'ingredient/images';
    public const IMAGE_UPLOAD_OPTIONS = [
        'width'   => 128,
        'format'  => 'webp',
        'quality' => 90,
        'has_thumb' => false
    ];

    protected $fillable = ['name', 'name_en', 'slug', 'image', 'show_in_search', 'calories_per_100g', 'fat_per_100g', 'carbs_per_100g', 'protein_per_100g'];

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'ingredient_units', 'ingredient_id', 'unit_id')->withPivot(['unit_weight_in_gram']);
    }
}
