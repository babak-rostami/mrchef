<?php

namespace App\Http\Requests\contact;

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
            'name' => ['required', 'string', 'min:3', 'max:60'],
            'body' => ['required', 'string', 'min:10', 'max:2000'],

            // هانی‌پات ضد اسپم: یک فیلد مخفیه که کاربر واقعی هیچوقت نمی‌بینتش و پرش نمی‌کنه،
            // ولی ربات‌های فرم‌پرکن معمولاً همه‌ی فیلدها رو پر می‌کنن.
            // پس اگه این فیلد مقدار داشت، یعنی احتمالاً ربات بوده و ولیدیشن رد میشه.
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'لطفاً نام خود را وارد کنید.',
            'name.min' => 'نام باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از :max کاراکتر باشد.',

            'body.required' => 'لطفاً متن پیام را بنویسید.',
            'body.min' => 'متن پیام باید حداقل :min کاراکتر باشد.',
            'body.max' => 'متن پیام نمی‌تواند بیشتر از :max کاراکتر باشد.',
        ];
    }
}
