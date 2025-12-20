<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            'username' => 'required|alpha_num|min:3|max:30|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.min' => 'نام باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از :max کاراکتر باشد.',

            'username.required' => 'وارد کردن نام کاربری الزامی است.',
            'username.alpha_num' => 'نام کاربری فقط شامل حروف انگلیسی و عدد باشد.',
            'username.min' => 'نام کاربری باید حداقل :min کاراکتر باشد.',
            'username.max' => 'نام کاربری نمی‌تواند بیشتر از :max کاراکتر باشد.',
            'username.unique' => 'این نام کاربری قبلاً ثبت شده است.',

            'email.required' => 'ایمیل خود را وارد کنید.',
            'email.email' => 'فرمت ایمیل وارد شده معتبر نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل :min کاراکتر باشد.',
            'password.confirmed' => 'تأیید رمز عبور مطابقت ندارد.',
        ];
    }
}
