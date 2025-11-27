<?php

namespace Database\Factories;

use App\Models\IngredientUnit;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeIngredient>
 */
class RecipeIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ingredient_unit = IngredientUnit::factory()->create();
        return [
            'recipe_id' => Recipe::factory()->create()->id,
            'ingredient_id' => $ingredient_unit->ingredient_id,
            'unit_id' => $ingredient_unit->unit_id,
            'amount' => rand(10, 100)
        ];
    }
}
