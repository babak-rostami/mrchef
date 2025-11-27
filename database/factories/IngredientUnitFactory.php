<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientUnit>
 */
class IngredientUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ingredient_id' => Ingredient::factory()->create()->id,
            'unit_id' => Unit::factory()->create()->id,
            'unit_weight_in_gram' => rand(10, 100)
        ];
    }
}
