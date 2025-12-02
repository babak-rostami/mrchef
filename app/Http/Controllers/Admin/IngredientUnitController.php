<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ingredientUnit\StoreRequest;
use App\Http\Requests\ingredientUnit\UpdateRequest;
use App\Models\Ingredient;
use App\Models\IngredientUnit;
use App\Models\Unit;

class IngredientUnitController extends Controller
{
    public function index($ingredient_slug)
    {
        $ingredient = Ingredient::where('slug', $ingredient_slug)->with('units')->first();
        if (!isset($ingredient)) {
            return back()->with('error', 'ماده اولیه پیدا نشد');
        }
        $units = Unit::all();

        return view('ingredient-unit.index', compact('ingredient', 'units'));
    }

    /**
     * ذخیره وزن واحد اندازه گیری جدید برای ماده اولیه
     */
    public function store(StoreRequest $request, $ingredient_slug)
    {
        $data = $request->validated();

        $ingredient = Ingredient::where('slug', $ingredient_slug)->with('units')->first();
        if (!isset($ingredient)) {
            return back()->with('error', 'ماده اولیه پیدا نشد');
        }

        $ingredientUnit = IngredientUnit::where('ingredient_id', $ingredient->id)
            ->where('unit_id', $data['unit_id'])->first();

        if ($ingredientUnit) {
            return back()->with('error', 'وزن این واحد قبلا ثبت  شده است');
        }

        $data['ingredient_id'] = $ingredient->id;

        IngredientUnit::create($data);

        return redirect()
            ->back()
            ->with('success', 'واحد اندازه گیری با موفقیت ثبت شد.');
    }

    /**
     * بروزرسانی وزن واحد
     */
    public function update(UpdateRequest $request, $ingredient_id, $unit_id)
    {
        $data = $request->validated();

        $ingredientUnit = IngredientUnit::where('ingredient_id', $ingredient_id)->where('unit_id', $unit_id)->first();

        if (!$ingredientUnit) {
            return back()->with('error', 'وزن واحد اندازه گیری پیدا تشد');
        }

        $ingredientUnit->update($data);

        return redirect()->back()->with('success', 'وزن واحد اندازه گیری با موفقیت بروزرسانی شد.');
    }

    public function destroy($ingredient_id, $unit_id)
    {
        $ingredientUnit = IngredientUnit::where('ingredient_id', $ingredient_id)->where('unit_id', $unit_id)->first();

        if (!$ingredientUnit) {
            return back()->with('error', 'وزن واحد اندازه گیری پیدا تشد');
        }

        $ingredientUnit->delete();

        return redirect()->back()->with('success', 'وزن واحد اندازه گیری حذف شد.');
    }
}
