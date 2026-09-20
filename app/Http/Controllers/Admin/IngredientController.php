<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ingredient\StoreRequest;
use App\Http\Requests\ingredient\UpdateRequest;
use App\Models\Ingredient;
use App\Models\IngredientUnit;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IngredientController extends Controller
{

    public function __construct(private ImageUploadService $images) {}

    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredient.index', compact('ingredients'));
    }

    public function create()
    {
        $show_select_options = [
            ['value' => 0, 'label' => 'خیر'],
            ['value' => 1, 'label' => 'بله']
        ];
        return view('ingredient.create', compact('show_select_options'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filename = Str::limit($data['slug'], 20);
            $path = $this->images->upload(
                $request->file('image'),
                Ingredient::IMAGE_DIRECTORY,
                array_merge(Ingredient::IMAGE_UPLOAD_OPTIONS, ['filename' => $filename])
            );
            $data['image'] = $path;
        }

        Ingredient::create($data);

        return redirect()->route('admin.ingredient.index')->with('success', 'ماده اولیه با موفقیت ثبت شد');
    }


    public function edit($slug)
    {
        $ingredient = Ingredient::where('slug', $slug)->first();
        if (!$ingredient) {
            return redirect()->route('admin.ingredient.index')->with('error', 'ماده اولیه پیدا نشد');
        }
        $show_select_options = [
            ['value' => 0, 'label' => 'خیر'],
            ['value' => 1, 'label' => 'بله']
        ];

        return view('ingredient.edit', compact('ingredient', 'show_select_options'));
    }

    public function update(UpdateRequest $request, $slug)
    {
        $data = $request->validated();
        $ingredient = Ingredient::where('slug', $slug)->first();
        if (!$ingredient) {
            return back()->with('error', 'ماده اولیه پیدا نشد');
        }

        if ($request->hasFile('image')) {
            $path = $this->images->replace(
                $request->file('image'),
                $ingredient->image_path,
                Ingredient::IMAGE_DIRECTORY,
                Ingredient::IMAGE_UPLOAD_OPTIONS
            );
            $data['image'] = $path;
        }

        $ingredient->update($data);

        return redirect()->route('admin.ingredient.index')->with('success', 'تغییرات با موفقیت ثبت شد');
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);

        if (!$ingredient) {
            return back()->with('error', 'ماده اولیه وجود ندارد');
        }

        if ($ingredient->image) {
            $this->images->delete($ingredient->image_path);
        }

        $ingredient->delete();

        return redirect()->route('admin.ingredient.index')->with('success', 'ماده اولیه با موفقیت حذف شد');
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
