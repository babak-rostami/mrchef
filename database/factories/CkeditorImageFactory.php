<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CkeditorImage>
 */
class CkeditorImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => fake()->imageUrl(),
            'editorable_id' => null,
            'editorable_type' => null,
        ];
    }

    public function forModel($model)
    {
        return $this->state(function () use ($model) {
            return [
                'editorable_id' => $model->id,
                'editorable_type' => get_class($model),
            ];
        });
    }
}
