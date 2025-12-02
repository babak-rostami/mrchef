<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CkeditorImage;
use App\Models\Recipe;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BFCkeditorController extends Controller
{

    public function upload(Request $request, $page, ImageService $imageService)
    {
        try {
            $this->validateUpload($request);

            $file = $request->file('upload');

            $fileName = $this->generateFileName();

            //مسیر ذخیره عکس با توجه به page
            $path = $this->uploadPath($page);

            $imagePath = $imageService->upload($file, $fileName, $path, 0);

            $editorImage = $this->storeEditorImage($imagePath);

            return response()->json([
                'filename' => $fileName,
                'uploaded' => 1,
                'url' => $editorImage->image_url
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'خطا در آپلود تصویر'
                ]
            ], 422);
        }
    }

    private function validateUpload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp'
        ]);
    }

    private function generateFileName()
    {
        $random = Str::lower(Str::random(6));
        return $random . '-' . time();
    }

    private function uploadPath($page)
    {
        switch ($page) {
            case 'recipe_create':
                return Recipe::EDITOR_PATH;
                break;
            case 'recipe_edit':
                return Recipe::EDITOR_PATH;
                break;
            case 'category_create':
                return Category::EDITOR_PATH;
                break;
            case 'category_edit':
                return Category::EDITOR_PATH;
                break;
            default:
                throw new \Exception("Invalid upload page: {$page}");
        }
    }

    private function storeEditorImage($path)
    {
        return CkeditorImage::create([
            'image' => $path,
            'editorable_id' => null,
            'editorable_type' => null,
        ]);
    }
}
