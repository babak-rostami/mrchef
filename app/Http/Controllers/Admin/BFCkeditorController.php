<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CkeditorImage;
use App\Models\Comment;
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

    /**
     * نگاشت کوتاه‌نویسِ مدل (همونی که توی آدرس آپلود میاد، مثل 'recipe')
     * به کلاس واقعیش. برای یه مدل جدید، فقط یه خط اینجا اضافه کن — خودِ
     * مدل باید EDITOR_FIELDS داشته باشه (نگاه کن به docs/EDITOR_SERVICE.md).
     */
    private const MODELS = [
        'recipe' => Recipe::class,
        'category' => Category::class,
        'comment' => Comment::class,
    ];

    /**
     * آپلود یه عکس برای یه فیلد ادیتوری مشخص.
     * آدرس: POST /admin_page/bf-ckeditor-upload/{model}/{field}
     * مثال: .../bf-ckeditor-upload/recipe/body
     */
    public function upload(Request $request, string $model, string $field)
    {
        try {
            $this->validateUpload($request);

            $uploadPath = $this->resolveUploadPath($model, $field);

            $file = $request->file('upload');
            $fileName = $this->generateFileName();

            $imagePath = $this->images->upload(
                $file,
                $uploadPath . '/',
                array_merge(self::IMAGE_UPLOAD_OPTIONS, ['filename' => $fileName])
            );

            $editorImage = $this->storeEditorImage($imagePath, $field);

            return response()->json([
                'filename' => $fileName,
                'uploaded' => 1,
                'url' => $editorImage->image_url
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'خطا در آپلود تصویر' . $e->getMessage()
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

    /**
     * مسیر آپلود رو از روی EDITOR_FIELDS همون مدل برمی‌گردونه.
     */
    private function resolveUploadPath(string $model, string $field): string
    {
        if (! isset(self::MODELS[$model])) {
            throw new \InvalidArgumentException("مدل «{$model}» توی BFCkeditorController::MODELS ثبت نشده.");
        }

        $modelClass = self::MODELS[$model];
        $fields = $modelClass::EDITOR_FIELDS ?? [];

        if (! isset($fields[$field])) {
            throw new \InvalidArgumentException("فیلد «{$field}» برای مدل «{$model}» توی EDITOR_FIELDS تعریف نشده.");
        }

        return $fields[$field];
    }

    private function storeEditorImage(string $path, string $field): CkeditorImage
    {
        return CkeditorImage::create([
            'image' => $path,
            'field' => $field,
            'editorable_id' => null,
            'editorable_type' => null,
        ]);
    }
}
