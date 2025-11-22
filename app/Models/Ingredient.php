<?php

namespace App\Models;

use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Imageable;

    const STORE_IMAGE_PATH = 'ingredient';

    protected $fillable = ['name', 'name_en', 'slug', 'image', 'show_in_search'];
}
