<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Imageable
{
    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::url($this->image)
            : null;
    }

    public function getThumbUrlAttribute()
    {
        if (!$this->image) return null;

        $thumb = str_replace('.webp', '2.webp', $this->image);

        return Storage::url($thumb);
    }

    public function getImageNameAttribute()
    {
        $info = pathinfo($this->image);
        $name = $info['filename'];
        return $name;
    }
}
