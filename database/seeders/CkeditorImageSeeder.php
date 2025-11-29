<?php

namespace Database\Seeders;

use App\Models\CkeditorImage;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CkeditorImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (CkeditorImage::count() == 0) {
            $recipe = Recipe::factory()->create();
            CkeditorImage::factory()->forModel($recipe)->create();
        }
    }
}
