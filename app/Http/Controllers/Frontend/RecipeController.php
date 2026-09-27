<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use App\Support\Schema\ItemListSchema;
use App\Support\Schema\RecipeSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index($category_slug = null)
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });

        $category = $categories->where('slug', $category_slug)->first();

        if ($category) {
            $compact_data['categories'] = $categories->where('id', '!=', $category->id);
            $compact_data['category'] = $category;
            $compact_data['recipes'] = Recipe::latest()->active()->where('category_id', $category->id)->get();
        } else {
            $compact_data['categories'] = $categories;
            $compact_data['recipes'] = Recipe::latest()->active()->get();
        }

        $compact_data['recipesSchema'] = $compact_data['recipes']->isNotEmpty()
            ? ItemListSchema::buildForRecipes($compact_data['recipes'])
            : null;

        return view('frontend.recipes.index', $compact_data);
    }

    public function show(Request $request, Recipe $recipe): View
    {
        $ingredients = $recipe->ingredientsWithUnit;
        $comments = $recipe->commentsWithUser;
        $recipeSchema = RecipeSchema::build($recipe, $ingredients);

        return view('frontend.recipes.show', compact('recipe', 'comments', 'ingredients', 'recipeSchema'));
    }
}
