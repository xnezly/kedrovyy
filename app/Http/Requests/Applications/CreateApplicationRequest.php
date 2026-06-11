<?php

namespace App\Http\Requests\Applications;

use App\Models\Room;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        $allowedServiceIds = $this->allowedServiceIds();

        return [
            'number_of_guests' => ['required', 'integer', 'min:1'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'comment' => ['nullable', 'string'],
            'services' => ['nullable', 'array'],
            'services.*' => [
                'integer',
                Rule::exists(Service::class, 'id'),
                function (string $attribute, mixed $value, \Closure $fail) use ($allowedServiceIds): void {
                    if (!in_array((int) $value, $allowedServiceIds, true)) {
                        $fail('Можно выбрать только баню и купель, если они не входят в выбранный номер.');
                    }
                },
            ],
        ];
    }

    private function allowedServiceIds(): array
    {
        $room = $this->route('room');

        if (!$room instanceof Room) {
            return [];
        }

        $room->loadMissing('services:id');

        return Service::query()
            ->bookingAddons()
            ->whereNotIn('id', $room->services->pluck('id'))
            ->pluck('id')
            ->map(static fn (mixed $id): int => (int) $id)
            ->all();
    }
}
