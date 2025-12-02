<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\recipeIngredient\StoreRequest;
use App\Http\Requests\recipeIngredient\UpdateRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeIngredientController extends Controller
{
    public function index($recipe_slug)
    {
        $recipe = Recipe::where('slug', $recipe_slug)->with('ingredients')->first();

        //get recipe ingredients
        $r_ingredients = DB::table('recipe_ingredients as ri')
            ->join('ingredients as i', 'i.id', '=', 'ri.ingredient_id')
            ->join('units as u', 'u.id', '=', 'ri.unit_id')
            ->where('ri.recipe_id', $recipe->id)
            ->select('i.id', 'i.name', 'ri.amount', 'u.name as unit_name')
            ->get();

        if (!isset($recipe)) {
            return back()->with('error', 'رسپی پیدا نشد');
        }
        $ingredients = Ingredient::all();

        return view('recipe-ingredient.index', compact('recipe', 'ingredients', 'r_ingredients'));
    }

    /**
     * ذخیره مقدار و مواد لازم رسپی
     */
    public function store(StoreRequest $request, $recipe_id)
    {
        $data = $request->validated();

        $recipe = Recipe::find($recipe_id);
        if (!isset($recipe)) {
            return back()->with('error', 'طرز تهیه پیدا نشد');
        }

        $recipe_ingredient = RecipeIngredient::where('recipe_id', $recipe->id)
            ->where('ingredient_id', $data['ingredient_id'])->first();

        if ($recipe_ingredient) {
            return back()->with('error', 'این ماده اولیه قبلا ثبت  شده است');
        }

        $data['recipe_id'] = $recipe->id;

        RecipeIngredient::create($data);

        return redirect()
            ->back()
            ->with('success', 'مقدار لازم با موفقیت ثبت شد.');
    }

    /**
     * بروزرسانی وزن واحد
     */
    public function update(UpdateRequest $request, $recipe_id, $ingredient_id)
    {
        $data = $request->validated();

        $recipe_ingredient = RecipeIngredient::where('recipe_id', $recipe_id)
            ->where('ingredient_id', $ingredient_id)->first();

        if (!$recipe_ingredient) {
            return back()->with('error', 'مقدار اولیه پیدا تشد');
        }

        $recipe_ingredient->update($data);

        return redirect()->back()->with('success', 'مقدار اولیه با موفقیت بروزرسانی شد.');
    }

    public function destroy($recipe_id, $ingredient_id)
    {
        $recipe_ingredient = RecipeIngredient::where('recipe_id', $recipe_id)
            ->where('ingredient_id', $ingredient_id)->first();

        if (!$recipe_ingredient) {
            return back()->with('error', 'مقدار لازم این ماده اولیه پیدا تشد');
        }

        $recipe_ingredient->delete();

        return redirect()->back()->with('success', 'مقدار لازم این ماده اولیه حذف شد.');
    }
}
