<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(2, true);
        $nameEn = Str::slug($name);

        return [
            'name' => $name,
            'name_en' => $nameEn,
            'label' => fake()->randomElement(['ق', 'ک', 'ل', 'گ', 'ق غ', 'ق چ', 'چ']),
        ];
    }
}
