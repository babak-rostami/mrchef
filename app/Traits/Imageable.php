<?php

namespace App\Traits;

use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;

trait Imageable
{
    /**
     * URL of main image
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ?
            app(ImageUploadService::class)->url($this->image, 'ftp')
            : $this->getDefaultImage();
    }

    /**
     * URL of thumbnail image
     */
    public function getThumbUrlAttribute()
    {
        if ($this->image) {
            $thumb = str_replace('.webp', '-thumb.webp', $this->image_url);
            return $thumb;
        }

        return $this->getDefaultImage();
    }

    /**
     * Extract filename only
     */
    public function getImageNameAttribute()
    {
        return pathinfo($this->image, PATHINFO_FILENAME);
    }

    public function getImagePathAttribute()
    {
        return $this->image;
    }
    public function getThumbPathAttribute()
    {
        return str_replace('.webp', '-thumb.webp', $this->getImagePathAttribute());
    }

    /**
     * Default image
     * Model can override this
     */
    private function getDefaultImage(): string
    {
        // اگر مدل متدی به اسم defaultImage داشته باشد، از همان استفاده می‌کنیم
        if (method_exists($this, 'defaultImage')) {
            return $this->defaultImage();
        }

        return config('images.ftp_path') . '/files/icon/default-image.png';
    }
}
