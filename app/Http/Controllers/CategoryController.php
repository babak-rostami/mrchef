<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
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

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!isset($category)) {
            return redirect()->route('category.index')->with('error', 'دسته بندی وجود ندارد');
        }
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('category.edit', compact('categories', 'category'));
    }

    public function update(UpdateRequest $request, ImageService $imageService, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $category->name        = $request->name;
        $category->name_en     = $request->name_en;
        $category->description = $request->description;
        $category->parent_id   = $request->parent_id;

        // اگر تصویر جدید آپلود شده
        if ($request->hasFile('image')) {

            // حذف تصویر قبلی (اختیاری)
            if ($category->image) {
                $imageService->delete($category->image);
            }

            $imagePath = $imageService->upload(
                $request->file('image'),
                $category->slug,
                'category',
                1
            );

            $category->image = $imagePath;
        }

        $category->update();

        return redirect()->route('category.index')->with('message', 'دسته‌بندی با موفقیت ویرایش شد');
    }
}
