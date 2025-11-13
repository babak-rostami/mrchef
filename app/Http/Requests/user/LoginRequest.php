<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
            'remember' => 'nullable|',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'لطفاً ایمیل خود را وارد کنید.',
            'email.email' => 'ایمیل معتبر نیست.',
            'email.exists' => 'کاربری با این ایمیل پیدا نشد.',
            'password.required' => 'لطفاً رمز عبور را وارد کنید.',
            'password.min' => 'رمز عبور حداقل باید 6 کاراکتر باشد.',
        ];
    }
}
