<?php

namespace App\Http\Controllers;

use App\Http\Requests\recipe\StoreRequest;
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
            $imagePath = $imageService->upload($request->file('image'), Str::limit($request->slug, 20), 'recipe', 1);
            $data['image'] = $imagePath;
        }

        $data['user_id'] = auth('user')->id();

        $recipe = Recipe::create($data);

        $editorService->store(Recipe::EDITOR_KEY, $recipe);

        return redirect()->route('recipes.index');
    }
}
