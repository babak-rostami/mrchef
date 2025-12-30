<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ImageManager extends Facade
{
    /**
     * Create a new class instance.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'image-service';
    }
}
