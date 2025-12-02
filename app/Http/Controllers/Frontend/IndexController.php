<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;

class IndexController extends Controller
{

    public function home()
    {
        $categories = Category::all();
        $recipes = Recipe::all();
        $sigleRecipe = $recipes->first();
        return view('home', compact('categories', 'recipes', 'sigleRecipe'));
    }
}
