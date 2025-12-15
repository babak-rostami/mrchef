<?php

namespace App\Http\Requests\comment;

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
            'body' => ['required', 'string'],
            'object_page' => ['string'],
            'object_id' => ['integer'],
            'comment_id' => ['nullable', 'exists:comments,id'],
            'parent_id' => ['nullable', 'exists:comments,id'],
            'reply_id' => ['nullable', 'exists:comments,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'لطفاً نظر خود را وارد کنید.',

            'parent_id.exists' => 'نظری که به آن پاسخ داده اید حذف شده است.',
            'reply_id.exists' => 'نظری که به آن پاسخ داده اید حذف شده است.',
        ];
    }
}
