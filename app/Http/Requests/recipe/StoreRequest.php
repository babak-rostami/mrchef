<?php

namespace App\Http\Requests\recipe;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'    => ['required', 'exists:categories,id'],
            'title'          => ['required', 'string', 'min:15', 'max:55'],
            'slug'           => ['required', 'string', 'min:15', 'max:55', 'unique:recipes,slug'],
            'description'    => ['required', 'string', 'min:25'],
            'body'           => ['required', 'string'],
            'status'         => ['nullable', 'integer'],
            'image'          => ['required', 'image', 'mimes:jpg,jpeg,png,webp'],
            'time_prepare'   => ['nullable', 'integer'],
            'time_cook'      => ['nullable', 'integer'],
            'servings'       => ['nullable', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category_id.exists'   => 'دسته‌بندی انتخاب شده معتبر نیست.',

            'title.required'       => 'عنوان الزامی است.',
            'title.min'            => 'عنوان نمی‌تواند کمتر از 15 کاراکتر باشد.',
            'title.max'            => 'عنوان نمی‌تواند بیشتر از 55 کاراکتر باشد.',

            'slug.required'        => 'اسلاگ الزامی است.',
            'slug.min'             => 'اسلاگ نمی‌تواند کمتر از 15 کاراکتر باشد.',
            'slug.max'             => 'اسلاگ نمی‌تواند بیشتر از 55 کاراکتر باشد.',
            'slug.unique'          => 'اسلاگ تکراری است، لطفاً مقدار دیگری وارد کنید.',

            'description.required' => 'توضیحات الزامی است.',
            'description.min'      => 'توضیحات نمی‌تواند کمتر از 25 کاراکتر باشد.',

            'body.required'        => 'متن محتوا الزامی است.',

            'image.required'       => 'آپلود تصویر الزامی است.',
            'image.image'          => 'فایل انتخاب شده یک تصویر معتبر نیست.',
            'image.mimes'          => 'فرمت تصویر باید jpg، jpeg، png یا webp باشد.',

            'time_prepare.integer' => 'زمان آماده‌سازی باید به صورت عددی باشد.',
            'time_cook.integer'    => 'زمان پخت باید به صورت عددی باشد.',
            'servings.integer'     => 'تعداد سرو باید به صورت عددی باشد.',
        ];
    }
}
