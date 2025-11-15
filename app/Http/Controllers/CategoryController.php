<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\StoreRequest;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function store(StoreRequest $request, ImageService $imageService)
    {
        $request->validated();
        $slug = preg_replace('~[^\pL\d]+~u', '-', $request->name_en);

        $category = new Category();
        $category->name = $request->name;
        $category->name_en = $request->name_en;
        $category->slug = $slug;
        $category->description = $request->description;
        if (isset($request->parent_id)) {
            $category->parent_id = $request->parent_id;
        }
        if ($request->hasFile('image')) {
            $imagePath = $imageService->upload($request->file('image'), $slug, 'category', 1);
            $category->image = $imagePath;
        }
        $category->save();
        return back()->with('message', 'دسته بندی با موفقیت ایجاد شد');
    }
}
