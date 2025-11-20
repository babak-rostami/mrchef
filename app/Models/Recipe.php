<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_PENDING = 2;
    const EDITOR_PATH = 'recipe/editor/1';
    const EDITOR_KEY = 'recipe';

    protected $fillable = ['category_id', 'user_id', 'title', 'slug', 'description', 'body', 'status', 'image', 'time_prepare', 'time_cook', 'servings'];

    public function editorImages()
    {
        return $this->morphMany(CkeditorImage::class, 'editorable');
    }
}
