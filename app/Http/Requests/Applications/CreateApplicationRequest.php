<?php

namespace App\Http\Requests\Applications;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'number_of_guests' => ['required', 'integer', 'min:1'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'comment' => ['nullable', 'string'],
            'services' => ['nullable', 'array'],
            'services.*' => ['integer', Rule::exists(Service::class, 'id')],
        ];
    }
}
