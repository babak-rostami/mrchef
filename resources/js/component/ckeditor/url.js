/**
 * آدرس آپلود عکس یه فیلد ادیتوری رو می‌سازه.
 *
 * model/field باید دقیقاً با چیزی که سمت PHP توی BFCkeditorController::MODELS
 * و EDITOR_FIELDS همون مدل تعریف کردی یکی باشه (مثلاً 'recipe'/'body').
 *
 * مثال:
 *   ckeditorUploadUrl('recipe', 'body', 'recipes-store-form')
 *   → '/admin_page/bf-ckeditor-upload/recipe/body?_token=...'
 */
export function ckeditorUploadUrl(model, field, form_id) {
    const token = document
        .getElementById(form_id)
        .querySelector('input[name="_token"]').value;

    return `/admin_page/bf-ckeditor-upload/${model}/${field}?_token=${token}`;
}
