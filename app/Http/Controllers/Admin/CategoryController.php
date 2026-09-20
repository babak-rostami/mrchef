<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageUploadService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(private ImageUploadService $images) {}

    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)->get();
        return view('category.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filename = Str::limit($data['slug'], 20);
            $path = $this->images->upload(
                $request->file('image'),
                Category::IMAGE_DIRECTORY,
                array_merge(Category::IMAGE_UPLOAD_OPTIONS, ['filename' => $filename])
            );
            $data['image'] = $path;
        }

        Category::create($data);

        return redirect()->route('admin.category.index')->with('success', 'دسته بندی با موفقیت ایجاد شد');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!isset($category)) {
            return redirect()->route('admin.category.index')->with('error', 'دسته بندی وجود ندارد');
        }
        $categories = Category::where('parent_id', null)->where('id', '!=', $category->id)->get();
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
            $path = $this->images->replace(
                $request->file('image'),
                $category->image_path,
                Category::IMAGE_DIRECTORY,
                Category::IMAGE_UPLOAD_OPTIONS
            );

            $data['image'] = $path;
        }

        $category->update($data);

        return redirect()->route('admin.category.index')->with('success', 'دسته‌بندی با موفقیت ویرایش شد');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!isset($category)) {
            return back()->with('error', 'دسته بندی وجود ندارد');
        }

        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'دسته‌بندی با موفقیت حذف شد');
    }
}
