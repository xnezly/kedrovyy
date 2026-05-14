<?php

namespace App\Http\Requests\Applications;

use App\Enums\ApplicationStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(ApplicationStatusEnum::class)],
        ];
    }
}
