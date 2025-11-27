<?php

namespace App\Http\Controllers;

use App\Http\Requests\ingredient\StoreRequest;
use App\Http\Requests\ingredient\UpdateRequest;
use App\Models\Ingredient;
use App\Models\IngredientUnit;
use App\Services\ImageService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IngredientController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Ingredient::class);
        $ingredients = Ingredient::all();
        return view('ingredient.index', compact('ingredients'));
    }

    public function create()
    {
        $this->authorize('create', Ingredient::class);
        $show_select_options = [
            ['value' => 0, 'label' => 'خیر'],
            ['value' => 1, 'label' => 'بله']
        ];
        return view('ingredient.create', compact('show_select_options'));
    }

    public function store(StoreRequest $request, ImageService $imageService)
    {
        $this->authorize('create', Ingredient::class);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $imageService->upload($request->file('image'), Str::limit($request->slug, 20), Ingredient::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        Ingredient::create($data);

        return redirect()->route('ingredient.index')->with('success', 'ماده اولیه با موفقیت ثبت شد');
    }


    public function edit($slug)
    {
        $ingredient = Ingredient::where('slug', $slug)->first();
        $this->authorize('update', $ingredient);
        $show_select_options = [
            ['value' => 0, 'label' => 'خیر'],
            ['value' => 1, 'label' => 'بله']
        ];

        return view('ingredient.edit', compact('ingredient', 'show_select_options'));
    }

    public function update(UpdateRequest $request, $slug, ImageService $imageService)
    {
        $data = $request->validated();
        $ingredient = Ingredient::where('slug', $slug)->first();
        if (!$ingredient) {
            return back()->with('error', 'ماده اولیه پیدا نشد');
        }
        $this->authorize('update', $ingredient);

        if ($request->hasFile('image')) {
            $imageService->delete($ingredient->image);
            $imagePath = $imageService->upload($request->file('image'), $ingredient->image_name, Ingredient::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $ingredient->update($data);

        return redirect()->route('ingredient.index')->with('success', 'تغییرات با موفقیت ثبت شد');
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);
        $this->authorize('delete', $ingredient);

        if (!isset($ingredient)) {
            return back()->with('error', 'ماده اولیه وجود ندارد');
        }

        $ingredient->delete();

        return redirect()->route('ingredient.index')->with('success', 'ماده اولیه با موفقیت حذف شد');
    }

    public function units($ingredient_id)
    {
        $units = IngredientUnit::where('ingredient_id', $ingredient_id)
            ->with('unit:id,name')
            ->get()
            ->pluck('unit');

        return response()->json($units);
    }
}
