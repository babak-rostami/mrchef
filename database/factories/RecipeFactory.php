<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->words(5, true);
        return [
            'category_id'    => Category::factory()->create()->id,
            'user_id'        => User::factory()->create()->id,
            'title'          => $title,
            'slug'           => Str::slug($title) . uniqid(),
            'description'    => $this->faker->paragraph(),
            'body'           => $this->faker->paragraph(),
            'status'         => $this->faker->randomElement([0, 1]),
            'time_prepare'   => rand(5, 600),
            'time_cook'      => rand(5, 600),
            'servings'       => rand(1, 20),
        ];
    }
}
