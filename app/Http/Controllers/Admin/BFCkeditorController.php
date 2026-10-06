<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CkeditorImage;
use App\Models\Recipe;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BFCkeditorController extends Controller
{
    public function __construct(private ImageUploadService $images) {}

    public const IMAGE_UPLOAD_OPTIONS = [
        'width'   => 1000,
        'format'  => 'webp',
        'quality' => 90,
        'has_thumb' => false
    ];

    public function upload(Request $request, $page)
    {
        try {
            $this->validateUpload($request);

            $file = $request->file('upload');

            $fileName = $this->generateFileName();

            //مسیر ذخیره عکس با توجه به page
            $path = $this->uploadPath($page) . '/';

            $imagePath = $this->images->upload(
                $file,
                $path,
                array_merge(self::IMAGE_UPLOAD_OPTIONS, ['filename' => $fileName])
            );

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
        $random = Str::lower(Str::random(4));
        return $random . time();
    }

    private function uploadPath($page)
    {
        return match ($page) {
            'recipe_create' => Recipe::EDITOR_PATH,
            'recipe_edit' => Recipe::EDITOR_PATH,
            'category_create' => Category::EDITOR_PATH,
            'category_edit' => Category::EDITOR_PATH,
            // نظرات فقط edit دارن؛ ثبت اولیه‌ی نظر از پنل ادمین نیست
            'comment_edit' => Comment::EDITOR_PATH,
        };
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
