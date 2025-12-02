<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Imageable
{
    /**
     * URL of main image
     */
    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::url($this->image)
            : $this->getDefaultImage();
    }

    /**
     * URL of thumbnail image
     */
    public function getThumbUrlAttribute()
    {
        if ($this->image) {
            $thumb = str_replace('.webp', '2.webp', $this->image);
            return Storage::url($thumb);
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

    /**
     * Default image
     * Model can override this
     */
    private function getDefaultImage()
    {
        // اگر مدل متدی به اسم defaultImage داشته باشد، از همان استفاده می‌کنیم
        if (method_exists($this, 'defaultImage')) {
            return $this->defaultImage();
        }

        return asset('files/icon/empty-list.png');
    }
}
