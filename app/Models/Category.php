<?php

namespace App\Models;

use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Imageable, HasFactory;

    const EDITOR_PATH = 'category/editor/1';
    const STORE_IMAGE_PATH = 'category';
    const EDITOR_KEY = 'category';

    protected $fillable = ['name', 'name_en', 'slug', 'description', 'body', 'image', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function editorImages()
    {
        return $this->morphMany(CkeditorImage::class, 'editorable');
    }

    public function defaultImage(): string
    {
        return asset('files/icon/default-category.png');
    }
}
