<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    protected $fillable = ['recipe_id', 'ingredient_id', 'unit_id', 'amount'];
}
