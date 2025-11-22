<?php

namespace App\Http\Controllers;

use App\Http\Requests\recipe\StoreRequest;
use App\Http\Requests\recipe\UpdateRequest;
use App\Models\Category;
use App\Models\Recipe;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Recipe::class);
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        $this->authorize('create', Recipe::class);
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    public function store(StoreRequest $request, ImageService $imageService, CkeditorService $editorService)
    {
        $this->authorize('create', Recipe::class);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $imageService->upload($request->file('image'), Str::limit($request->slug, 20), Recipe::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $data['user_id'] = auth('user')->id();

        $recipe = Recipe::create($data);

        $editorService->store(Recipe::EDITOR_KEY, $recipe);

        return redirect()->route('recipes.index')->with('success', 'رسپی با موفقیت ثبت شد');
    }

    public function edit($slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();
        $this->authorize('update', $recipe);

        $categories = Category::all();
        return view('recipes.edit', compact('categories', 'recipe'));
    }

    public function update(UpdateRequest $request, $slug, ImageService $imageService, CkeditorService $editorService)
    {
        $data = $request->validated();
        $recipe = Recipe::where('slug', $slug)->first();
        if (!$recipe) {
            return back()->with('error', 'رسپی پیدا نشد');
        }
        $this->authorize('update', $recipe);

        if ($request->hasFile('image')) {
            $imageService->delete($recipe->image);
            $imagePath = $imageService->upload($request->file('image'), $recipe->image_name, Recipe::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $recipe->update($data);

        $editorService->update(Recipe::EDITOR_KEY, $recipe);

        return redirect()->route('recipes.index')->with('success', 'تغییرات با موفقیت ثبت شد');
    }
}
