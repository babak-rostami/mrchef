<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\recipe\StoreRequest;
use App\Http\Requests\recipe\UpdateRequest;
use App\Models\Category;
use App\Models\Recipe;
use App\Services\ckeditor\CkeditorService;
use App\Services\ImageService;
use Illuminate\Support\Str;

class RecipeController extends Controller
{

    private $imageService, $editorService;

    public function __construct(ImageService $imageService, CkeditorService $editorService)
    {
        $this->imageService = $imageService;
        $this->editorService = $editorService;
    }

    public function index()
    {
        $recipes = Recipe::latest()->get();
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
            $imagePath = $this->imageService->upload($request->file('image'), Str::limit($request->slug, 20), Recipe::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $data['user_id'] = auth('user')->id();

        $recipe = Recipe::create($data);

        $this->editorService->store(Recipe::EDITOR_KEY, $recipe);

        return redirect()->route('admin.recipes.index')->with('success', 'رسپی با موفقیت ثبت شد');
    }

    public function edit($slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();

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
            $this->imageService->delete($recipe->image);
            $imagePath = $this->imageService->upload($request->file('image'), $recipe->image_name, Recipe::STORE_IMAGE_PATH, 1);
            $data['image'] = $imagePath;
        }

        $recipe->update($data);

        $this->editorService->update(Recipe::EDITOR_KEY, $recipe);

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
