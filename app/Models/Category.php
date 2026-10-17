<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    use Imageable, HasFactory;

    public const IMAGE_DIRECTORY = 'category/images';
    public const IMAGE_UPLOAD_OPTIONS = [
        'width'   => 300,
        'format'  => 'webp',
        'quality' => 90,
        'has_thumb' => true
    ];

    /**
     * فیلدهای ادیتوریِ این مدل: اسم فیلد => مسیر آپلود عکس‌هاش.
     * @see \App\Services\Editor\EditorService
     */
    public const EDITOR_FIELDS = [
        'body' => 'category/editor',
    ];

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
        return config('images.ftp_path') . '/files/icon/default-category.png';
    }
}
