<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $imageService, $editorService;

    public function __construct(ImageService $imageService, CkeditorService $editorService)
    {
        $this->imageService = $imageService;
        $this->editorService = $editorService;
    }

    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('category.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $this->imageService->upload(
                $request->file('image'),
                Str::limit($data['slug'], 20),
                Category::STORE_IMAGE_PATH,
                1
            );
            $data['image'] = $imagePath;
        }

        $category = Category::create($data);

        $this->editorService->store(Category::EDITOR_KEY, $category);

        return redirect()->route('admin.category.index')->with('success', 'دسته بندی با موفقیت ایجاد شد');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!isset($category)) {
            return redirect()->route('admin.category.index')->with('error', 'دسته بندی وجود ندارد');
        }
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('category.edit', compact('categories', 'category'));
    }

    public function update(UpdateRequest $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!isset($category)) {
            return redirect()->route('admin.category.index', 'دسته بندی یافت نشد');
        }
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->imageService->delete($category->image);
            $imagePath = $this->imageService->upload($request->file('image'), $category->image_name, Category::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $category->update($data);

        $this->editorService->update(Category::EDITOR_KEY, $category);

        return redirect()->route('admin.category.index')->with('success', 'دسته‌بندی با موفقیت ویرایش شد');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

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

        return redirect()->route('admin.category.index')->with('success', 'دسته‌بندی با موفقیت حذف شد');
    }
}
