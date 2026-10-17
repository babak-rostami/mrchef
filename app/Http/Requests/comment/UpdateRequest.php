<?php

namespace App\Http\Requests\comment;

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
            // متن — هم برای نظر اصلی هم برای پاسخ قابل‌ویرایشه
            'body' => ['required', 'string'],
            // فقط برای نظر اصلی معنا داره؛ برای پاسخ اصلاً توی فرم نیست.
            // خالی بذاری یعنی نمایش برمی‌گرده به همون body
            'content' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'نظر نمی‌تواند خالی باشد.',
        ];
    }
}
