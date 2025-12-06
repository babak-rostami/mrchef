<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\View\View;

class IndexController extends Controller
{

    public function home(): View
    {
        $categories = Category::all();
        $recipes = Recipe::latest()->active()->get();

        //اولین رسپی رو بزرگ میخوام نشون بدم توی لیست دیگه نشون نده
        $sigleRecipe = $recipes->first();
        $recipes = $recipes->skip(1);

        return view('home', compact('categories', 'recipes', 'sigleRecipe'));
    }
}
