<?php

namespace App\Http\Requests\ingredient;

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
            'name'           => ['required', 'string', 'min:1', 'max:55'],
            'name_en'        => ['required', 'string', 'min:1', 'max:55'],
            'slug'           => ['required', 'string', 'min:2', 'max:55', 'unique:ingredients,slug'],
            'image'          => ['required', 'image', 'mimes:jpg,jpeg,png,webp'],
            'show_in_search' => ['nullable', 'integer'],
        ];
    }
}
