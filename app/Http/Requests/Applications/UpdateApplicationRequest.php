<?php

namespace App\Http\Requests\Applications;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class UpdateApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(ApplicationStatusEnum::class)],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->has('status')) {
                    return;
                }

                $status = ApplicationStatusEnum::tryFrom((string) $this->input('status'));

                if ($status !== ApplicationStatusEnum::CONFIRMED) {
                    return;
                }

                $application = $this->route('application');

                if (!$application instanceof Application) {
                    return;
                }

                $hasConfirmedConflict = Application::query()
                    ->where('room_id', $application->room_id)
                    ->whereKeyNot($application->id)
                    ->where('status', ApplicationStatusEnum::CONFIRMED->value)
                    ->overlapping($application->check_in, $application->check_out)
                    ->exists();

                if (!$hasConfirmedConflict) {
                    return;
                }

                $validator->errors()->add(
                    'status',
                    'Нельзя подтвердить эту заявку: по этому номеру на пересекающиеся даты уже есть другое подтвержденное бронирование.'
                );
            },
        ];
    }
}
