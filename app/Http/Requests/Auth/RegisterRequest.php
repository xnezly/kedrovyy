<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', Rule::unique(User::class)],
            'password' => ['required', 'string', 'min:6', 'max:20', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Введите ваше имя",
            'name.min' => "Имя должно быть не менее 2 символов",
            'phone.required' => "Введите номер телефона",
            'phone.unique' => "Этот номер уже зарегистрирован",
            'phone.regex' => "Введите номер в формате +7 (999) 123-45-67",
            'password.required' => "Введите пароль",
            'password.min' => "Пароль должен быть не менее 6 символов",
            'password.confirmed' => "Пароли не совпадают",
        ];
    }
}
