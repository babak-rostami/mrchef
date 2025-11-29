<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        $categories = Category::all();
        return view('category.create', compact('categories'));
    }

    public function store(StoreRequest $request, ImageService $imageService, CkeditorService $editorService)
    {
        $this->authorize('viewAny', Category::class);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $imageService->upload($request->file('image'), Str::limit($data['slug'], 20), Category::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $category = Category::create($data);

        $editorService->store(Category::EDITOR_KEY, $category);

        return redirect()->route('category.index')->with('success', 'دسته بندی با موفقیت ایجاد شد');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $this->authorize('update', $category);

        if (!isset($category)) {
            return redirect()->route('category.index')->with('error', 'دسته بندی وجود ندارد');
        }
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('category.edit', compact('categories', 'category'));
    }

    public function update(UpdateRequest $request, ImageService $imageService, CkeditorService $editorService, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $this->authorize('update', $category);
        if (!isset($category)) {
            return redirect()->route('category.index', 'دسته بندی یافت نشد');
        }
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imageService->delete($category->image);
            $imagePath = $imageService->upload($request->file('image'), $category->image_name, Category::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $category->update($data);

        $editorService->update(Category::EDITOR_KEY, $category);

        return redirect()->route('category.index')->with('success', 'دسته‌بندی با موفقیت ویرایش شد');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $this->authorize('delete', $category);

        if (!isset($category)) {
            return back()->with('error', 'دسته بندی وجود ندارد');
        }

        //         // حذف عکس اصلی
        if ($category->image) {
            $this->imageService->delete($category->image);
        }

        // حذف تصاویر CKEditor
        foreach ($category->editorImages as $editorImage) {
            $this->imageService->delete($editorImage->image);
            $editorImage->delete();
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'دسته‌بندی با موفقیت حذف شد');
    }
}
