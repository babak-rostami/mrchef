<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Recipe::count() == 0) {
            Recipe::factory()->create([
                'category_id' => $this->getCategory()->id,
                'user_id' => $this->getUser()->id,
            ]);
            Recipe::factory()->count(10)->create();
        }
    }

    private function getCategory()
    {
        $category = Category::where('parent_id', '!=', null)->first();
        if (!isset($category)) {
            $category = Category::frist();
        }
        return $category;
    }

    private function getUser()
    {
        $user = User::first();
        return $user;
    }
}
