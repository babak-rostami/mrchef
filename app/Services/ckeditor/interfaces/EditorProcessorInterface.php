<?php

namespace App\Services\ckeditor\interfaces;

interface EditorProcessorInterface
{
    /*-----------------------------------------------------------------------
    عکسایی که توی ادیتور استفاده شده، مسیر اصلی سایت رو ازش کم میکنه
    مسیر عکسای توی ادیتور رو توی یه آرایه برمیگردونه
    ----------------------------------------------------------------------*/
    public function getImagePathsInEditor($imageTags);
}
