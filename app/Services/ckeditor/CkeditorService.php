<?php

namespace App\Services\ckeditor;

use App\Models\CkeditorImage;
use App\Models\Recipe;
use App\Services\ckeditor\factories\EditorProcessorFactory;
use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/*-------------------------------------------------
مدیریت تصاویر CKEditor برای مدل‌های مختلف 
 متد store برای زمان ایجاد کردن مدل
 متد update برای زمان ویرایش کردن مدل
-------------------------------------------------*/

class CkeditorService
{
    /**
     * @param string $type
     * @param Model $editorable
     */
    public function store($type, $editorable)
    {
        $this->makeEditorImagesLazy($editorable);

        $this->addEditorImagesEditorableId($type, $editorable);
    }

    /**
     * @param string $type
     * @param Model $editorable
     */
    public function update($type, $editorable)
    {
        $this->makeEditorImagesLazy($editorable);

        $imageModelsInEditor = $this->addEditorImagesEditorableId($type, $editorable);

        $this->deleteOldImages($imageModelsInEditor, $editorable->id);
    }


    /*-------------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------------
    ----------------------------------private methods--------------------------------------
    ---------------------------------------------------------------------------------------
    -------------------------------------------------------------------------------------*/


    /*-------------------------------------------------
    تصویرای داخل ادیتور رو lazy load میکنه
    ---------------------------------------------------*/
    private function makeEditorImagesLazy($editorable)
    {
        $editorable->body = preg_replace(
            '/<img(?![^>]*loading=)([^>]*)>/i',
            '<img loading="lazy"$1>',
            $editorable->body
        );
        $editorable->update();
    }

    /*-------------------------------------------------
    با src عکسای داخل ادیتور، CkeditorImage هارو پیدا میکنه
    بعد editorable_id رو براشون ست میکنه اگه عکسای جدید هستن
    تا مشخص بشه این عکس مربوط به کدوم مدل هستش
    ---------------------------------------------------*/
    private function addEditorImagesEditorableId($type, $editorable)
    {
        $processor = EditorProcessorFactory::make($type);
        $dom = $this->loadDom($editorable->body);
        $imageTags = $dom->getElementsByTagName('img');
        $imagePaths = $processor->getImagePathsInEditor($imageTags);
        $imageModelsInEditor = $this->getModelImagesByPaths($imagePaths);
        $this->addNewImagesEditorable($imageModelsInEditor, $editorable);
        return $imageModelsInEditor;
    }

    /*-------------------------------------------------
    CkeditorImage هایی که مسیر عکسشون $imagePaths هست برمیگردونه
    برای پیدا کردن مدل CkeditorImage عکسای استفاده شده در یک ادیتور
    ---------------------------------------------------*/
    private function getModelImagesByPaths($imagePaths)
    {
        $images = CkeditorImage::whereIn('image', $imagePaths)->get();
        return $images;
    }

    /*-------------------------------------------------
    newImageModels یه کالکشن CkeditorImage هستش
    اونایی که editorable_id خالی هستش یعنی جدید هستن
    پس ستون های id و type رو با توجه به مدلی که دارم پر میکنم
    رابطه morph چون مدل های مختلفی میتونن CkeditorImage داشته باشت
    -------------------------------------------------*/
    private function addNewImagesEditorable($newImageModels, $editorable)
    {
        $newModelImages = $newImageModels->where('editorable_id', null);
        foreach ($newModelImages as $newImage) {
            $newImage->editorable()->associate($editorable);
            $newImage->update();
        }
        return $newModelImages;
    }

    /*-------------------------------------------------
    imageModelsInEditor یه کالکشن CkeditorImage هستش که توی ادیتور استفاده شدن
    CkeditorImage هایی که editorable_id برابر با $editorable_id داده شده دارن
    ولی ای دیشون توی imageModelsInEditor نیست یعنی قبلا بودن ولی الان توی ادیتور جدید نیستن
    یعنی عکس رو کاربر توی ادیتور پاک کرده
    پس اینجا حذفشون میکنیم
    -------------------------------------------------*/
    private function deleteOldImages($imageModelsInEditor, $editorable_id)
    {
        $deletedImages = CkeditorImage::where('editorable_id', $editorable_id)
            ->whereNotIn('id', $imageModelsInEditor->pluck('id'))->get();
        foreach ($deletedImages as $dimage) {
            $dimage->delete();
        }
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
