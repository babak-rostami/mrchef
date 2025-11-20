<?php

namespace App\Services\ckeditor\factories;

use App\Services\ckeditor\interfaces\EditorProcessorInterface;
use App\Services\ckeditor\strategies\RecipeEditorProcessor;

class EditorProcessorFactory
{
    /*-------------------------------------------------
    یه فکتوری که type رو میگیره
    یک آبجکت از کلاسی که implements EditorProcessorInterface میکنه برمیگردونه
    یک کلاس استراتژی برمیگردونه برای مدیریت ادیتور مرتبط با هر مدل
    ---------------------------------------------------*/
    public static function make(string $type): EditorProcessorInterface
    {
        return match ($type) {
            'recipe' => new RecipeEditorProcessor(),
            default  => throw new \Exception("Unknown editor processor type: $type")
        };
    }
}
