<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'regex:/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => "Введите номер телефона",
            'phone.regex' => "Введите номер в формате +7 (999) 123-45-67",
            'password.required' => "Введите пароль",
            'password.min' => "Пароль должен быть не менее 6 символов",
        ];
    }
}
