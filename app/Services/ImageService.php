<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    private string $ext = 'webp';
    private int $quality = 90;
    private int $thumbWidth = 250;

    /**
     * $hasThumb:
     * 0 = فقط تصویر اصلی
     * 1 = تصویر اصلی + تامبنیل  (دیفالت)
     */
    public function upload($file, string $name, string $path, int $hasThumb = 1)
    {
        $name = $this->slug($name);
        $name = $this->uniqueName($name, $path, $this->ext);

        $original = "{$path}/{$name}.{$this->ext}";
        $thumb    = "{$path}/{$name}2.{$this->ext}";

        /*
        |--------------------------------------------------------------------------
        | تصویر اصلی
        |--------------------------------------------------------------------------
        */
        if ($hasThumb === 0 || $hasThumb === 1) {

            $main = Image::make($file)
                ->encode($this->ext, $this->quality);

            Storage::put("{$original}", $main);
        }

        /*
        |--------------------------------------------------------------------------
        | تامبنیل
        |--------------------------------------------------------------------------
        */
        if ($hasThumb === 1) {

            $thumbnail = Image::make($file)
                ->resize($this->thumbWidth, null, function ($c) {
                    $c->aspectRatio();
                })
                ->encode($this->ext, $this->quality);

            Storage::put("{$thumb}", $thumbnail);
        }

        // همیشه مسیر عکس اصلی به دیتابیس بازگردانده می‌شود
        return $original;
    }

    private function slug($name)
    {
        $slug = str()->slug($name);
        return $slug ?: 'image';
    }

    public function delete(string $imagePath)
    {
        $info = pathinfo($imagePath);

        $path = $info['dirname'];
        $name = $info['filename'];

        $original = "{$path}/{$name}.{$this->ext}";
        $thumb    = "{$path}/{$name}2.{$this->ext}";

        Storage::delete([
            "{$original}",
            "{$thumb}",
        ]);
    }

    private function uniqueName(string $name, string $path, string $ext)
    {
        $new = $name;
        $i = 1;

        while (
            Storage::exists("{$path}/{$new}.{$ext}") ||
            Storage::exists("{$path}/{$new}2.{$ext}")
        ) {
            $new = "{$name}-{$i}";
            $i++;
        }

        return $new;
    }
}
