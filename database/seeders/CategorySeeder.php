<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() == 0) {
            Category::factory()->withParent()->create();
            $parent = Category::factory()->create();
            Category::factory(5)->create([
                'parent_id' => $parent->id
            ]);
        }
    }
}
