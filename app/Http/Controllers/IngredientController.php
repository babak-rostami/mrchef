<?php

namespace App\Http\Controllers;

use App\Http\Requests\ingredient\StoreRequest;
use App\Models\Ingredient;
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
        return view('ingredient.create');
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
}
