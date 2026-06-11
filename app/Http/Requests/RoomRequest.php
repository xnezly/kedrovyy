<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:1'],
            'images' => ['nullable', 'array', 'max:15'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'services' => ['nullable', 'array'],
            'services.*' => ['integer', Rule::exists(Service::class, 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'images.max' => 'Можно загрузить не более 15 фотографий за один раз.',
            'images.*.image' => 'Каждый выбранный файл должен быть изображением.',
            'images.*.mimes' => 'Разрешены только изображения JPG, JPEG, PNG и WEBP.',
            'images.*.max' => 'Каждая фотография должна быть не больше 10 МБ.',
        ];
    }
}
