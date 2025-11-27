<?php

namespace Database\Seeders;

use App\Models\RecipeIngredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (RecipeIngredient::count() == 0) {
            RecipeIngredient::factory()->count(5)->create();
        }
    }
}
