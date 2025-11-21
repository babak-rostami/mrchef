<?php

namespace App\Http\Requests\recipe;

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
            'category_id'    => ['nullable', 'exists:categories,id'],
            'title'          => ['required', 'string', 'min:15', 'max:55'],
            'description'    => ['required', 'string', 'min:25'],
            'body'           => ['required', 'string'],
            'status'         => ['nullable', 'integer'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'time_prepare'   => ['nullable', 'integer'],
            'time_cook'      => ['nullable', 'integer'],
            'servings'       => ['nullable', 'integer'],
        ];
    }
}
