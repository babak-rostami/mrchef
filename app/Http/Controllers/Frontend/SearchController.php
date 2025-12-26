<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');

        $recipes = Recipe::searchElastic($query);

        $recipes = $recipes->map(function ($recipe) {
            return [
                'title' => $recipe->title,
                'slug' => $recipe->slug,
                'image_url' => $recipe->image_url,
            ];
        });

        return response()->json([
            'recipes' => $recipes,
        ]);
    }
}
