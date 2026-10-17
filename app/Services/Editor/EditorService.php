<?php

namespace App\Services\Editor;

use App\Models\CkeditorImage;
use App\Services\ImageUploadService;
use DOMDocument;
use Illuminate\Database\Eloquent\Model;

/**
 * مدیریت تصاویر CKEditor برای هر فیلد از هر مدلی.
 *
 * هر مدل، فیلدهای ادیتوری خودش رو با ثابت EDITOR_FIELDS معرفی می‌کنه:
 *
 *   public const EDITOR_FIELDS = [
 *       'body' => 'recipe/editor',
 *   ];
 *
 * برای مدلی با چند فیلد ادیتوری (مثلاً Product با description و body)،
 * فقط چند تا ورودی به همین آرایه اضافه کن — بقیه‌ی این سرویس بدون
 * تغییر کار می‌کنه:
 *
 *   public const EDITOR_FIELDS = [
 *       'description' => 'product/editor/description',
 *       'body' => 'product/editor/body',
 *   ];
 *
 * یه (مدل، فیلد) با sync() پردازش میشه: عکس‌ها lazy میشن، عکس‌های
 * تازه‌آپلودشده به همین مدل/فیلد وصل میشن، عکس‌هایی که از محتوا حذف
 * شدن از دیسک و دیتابیس پاک میشن — محدود به همون فیلد، نه کل مدل.
 *
 * راهنمای کامل: docs/EDITOR_SERVICE.md
 */
class EditorService
{
    public function __construct(private ImageUploadService $images) {}

    /**
     * یه فیلد ادیتوری رو با محتوای فعلیش هماهنگ می‌کنه.
     * هم موقع ساخت مدل هم موقع ویرایشش، همینو صدا بزن.
     */
    public function sync(Model $editorable, string $field): void
    {
        if (! $editorable->{$field}) {
            return; // فیلد خالیه، چیزی برای پردازش نیست
        }

        $uploadPath = $this->uploadPath($editorable, $field);

        $this->makeImagesLazy($editorable, $field);

        $currentImages = $this->attachNewImages($editorable, $field, $uploadPath);

        $this->deleteRemovedImages($editorable, $field, $currentImages);
    }

    /*-------------------------------------------------
    تصاویر داخل محتوا رو lazy load می‌کنه
    ---------------------------------------------------*/
    private function makeImagesLazy(Model $editorable, string $field): void
    {
        $editorable->{$field} = preg_replace(
            '/<img(?![^>]*loading=)([^>]*)>/i',
            '<img loading="lazy"$1>',
            $editorable->{$field}
        );

        $editorable->saveQuietly();
    }

    /*-------------------------------------------------
    عکس‌های موجود توی محتوا رو پیدا می‌کنه و اگه تازه آپلود شدن
    (editorable_id خالی دارن) به همین مدل/فیلد وصلشون می‌کنه.
    عکسی که از قبل به یه مدل دیگه وصل بوده (مثلاً کپی/پیست از یه
    محتوای دیگه) دست‌نخورده می‌مونه.
    ---------------------------------------------------*/
    private function attachNewImages(Model $editorable, string $field, string $uploadPath)
    {
        $paths = $this->extractImagePaths($editorable->{$field}, $uploadPath);

        $images = CkeditorImage::whereIn('image', $paths)
            ->where('field', $field)
            ->get();

        $images->whereNull('editorable_id')->each(function (CkeditorImage $image) use ($editorable) {
            $image->editorable()->associate($editorable);
            $image->save();
        });

        return $images;
    }

    /*-------------------------------------------------
    عکس‌هایی که قبلاً به همین مدل/فیلد وصل بودن ولی الان دیگه توی
    محتوا نیستن (کاربر پاکشون کرده) رو از دیسک و دیتابیس حذف می‌کنه.
    محدود به همون فیلد، نه کل مدل — تا اگه مدل چند فیلد ادیتوری داشته
    باشه، ویرایش یه فیلد به عکس‌های فیلد دیگه دست نزنه.
    ---------------------------------------------------*/
    private function deleteRemovedImages(Model $editorable, string $field, $currentImages): void
    {
        $removed = CkeditorImage::where('editorable_id', $editorable->id)
            ->where('editorable_type', $editorable->getMorphClass())
            ->where('field', $field)
            ->whereNotIn('id', $currentImages->pluck('id'))
            ->get();

        foreach ($removed as $image) {
            $this->images->delete($image->image_path);
            $image->delete();
        }
    }

    /*-------------------------------------------------
    آدرس src تگ‌های <img> داخل HTML رو به مسیر نسبیِ قابل‌مقایسه با
    ستون image تبدیل می‌کنه (یعنی پیشوند دامنه/CDN رو حذف می‌کنه).
    فقط عکس‌هایی که زیر uploadPath همین فیلد هستن برمی‌گردن؛ عکسی که
    از جای دیگه (مثلاً یه سایت خارجی) پیست شده باشه نادیده گرفته میشه.
    ---------------------------------------------------*/
    private function extractImagePaths(string $html, string $uploadPath): array
    {
        $dom = $this->loadDom($html);
        $paths = [];

        foreach ($dom->getElementsByTagName('img') as $imageTag) {
            $src = $imageTag->getAttribute('src');
            $parts = explode($uploadPath, $src);

            if (isset($parts[1])) {
                $paths[] = $uploadPath . $parts[1];
            }
        }

        return $paths;
    }

    /**
     * مسیر آپلودِ این فیلد رو از روی EDITOR_FIELDS همون مدل برمی‌گردونه.
     */
    private function uploadPath(Model $editorable, string $field): string
    {
        $fields = $editorable::EDITOR_FIELDS ?? null;

        if (! $fields || ! isset($fields[$field])) {
            throw new \InvalidArgumentException(
                get_class($editorable) . "::EDITOR_FIELDS برای فیلد «{$field}» مسیری تعریف نکرده."
            );
        }

        return $fields[$field];
    }

    private function loadDom(string $html): DOMDocument
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8')
        );

        libxml_clear_errors();
        return $dom;
    }
}
