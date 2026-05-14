<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:1'],
            'icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название услуги',
            'price.required' => 'Введите цену',
            'price.integer' => 'Цена должна быть числом',
            'icon.image' => 'Загрузите изображение (JPEG, PNG, JPG, GIF)',
            'icon.max' => 'Размер фото не должен превышать 2MB',
        ];
    }
}
