<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\recipe\StoreRequest;
use App\Http\Requests\recipe\UpdateRequest;
use App\Models\Category;
use App\Models\Recipe;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageUploadService;
use Illuminate\Support\Str;

class RecipeController extends Controller
{

    public function __construct(private ImageUploadService $images, private CkeditorService $editorService) {}

    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        $categories = Category::all();
        $status_select_options = [
            ['value' => 0, 'label' => 'تایید نشده'],
            ['value' => 1, 'label' => 'تایید شده']
        ];
        return view('recipes.create', compact('categories', 'status_select_options'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filename = Str::limit($data['slug'], 20);
            $path = $this->images->upload(
                $request->file('image'),
                Recipe::IMAGE_DIRECTORY,
                array_merge(Recipe::IMAGE_UPLOAD_OPTIONS, ['filename' => $filename])
            );
            $data['image'] = $path;
        }

        $data['user_id'] = auth('user')->id();

        Recipe::create($data);

        return redirect()->route('admin.recipes.index')->with('success', 'رسپی با موفقیت ثبت شد');
    }

    public function edit($slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();
        if (!$recipe) {
            return back()->with('error', 'رسپی پیدا نشد');
        }
        $categories = Category::all();
        $status_select_options = [
            ['value' => 0, 'label' => 'تایید نشده'],
            ['value' => 1, 'label' => 'تایید شده']
        ];
        return view('recipes.edit', compact('categories', 'recipe', 'status_select_options'));
    }

    public function update(UpdateRequest $request, $slug)
    {
        $data = $request->validated();
        $recipe = Recipe::where('slug', $slug)->first();
        if (!$recipe) {
            return back()->with('error', 'رسپی پیدا نشد');
        }

        if ($request->hasFile('image')) {
            $path = $this->images->replace(
                $request->file('image'),
                $recipe->image_path,
                Recipe::IMAGE_DIRECTORY,
                Recipe::IMAGE_UPLOAD_OPTIONS
            );
            $data['image'] = $path;
        }

        $recipe->update($data);

        return redirect()->route('admin.recipes.index')->with('success', 'تغییرات با موفقیت ثبت شد');
    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if (!isset($recipe)) {
            return back()->with('error', 'رسپی وجود ندارد');
        }

        $recipe->delete();

        return redirect()->route('admin.recipes.index')->with('success', 'رسپی با موفقیت حذف شد');
    }
}
