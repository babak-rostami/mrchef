<?php

namespace Database\Seeders;

use App\Models\IngredientUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (IngredientUnit::count() == 0) {
            IngredientUnit::factory()->count(5)->create();
        }
    }
}
