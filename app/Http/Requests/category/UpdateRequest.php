<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'       => 'required|string|max:40',
            'name_en'    => 'required|string|max:40',
            'description' => 'required|string',
            'parent_id'  => 'nullable|exists:categories,id',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'نام دسته بندی را وارد کنید',
            'name_en.required' => 'نام انگلیسی دسته بندی را وارد کنید',
            'name.max' => 'نام دسته بندی باید حداکثر 40 کاراکتر باشد',
            'name_en.max' => 'نام انگلیسی دسته بندی باید حداکثر 40 کاراکتر باشد',
            'description.required' => 'توضیحات دسته بندی را وارد کنید',
            'image.image' => 'یک فرمت عکس صحیح انتخاب کنید',
        ];
    }
}
