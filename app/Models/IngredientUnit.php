<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientUnit extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient_id', 'unit_id', 'unit_weight_in_gram'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }
}
