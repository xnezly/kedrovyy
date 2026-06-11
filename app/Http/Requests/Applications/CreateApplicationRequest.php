<?php

namespace App\Http\Requests\Applications;

use App\Models\Application;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CreateApplicationRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $phone = preg_replace('/\D+/', '', (string) $this->input('number', ''));

        if (strlen($phone) === 11 && str_starts_with($phone, '8')) {
            $phone = '7' . substr($phone, 1);
        }

        $age = $this->input('age');

        $this->merge([
            'name' => trim((string) $this->input('name', '')),
            'number' => $phone,
            'age' => $age === '' || $age === null ? null : (int) $age,
        ]);
    }

    public function rules(): array
    {
        $allowedServiceIds = $this->allowedServiceIds();

        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'number' => ['required', 'string', 'regex:/^7\d{10}$/'],
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

    public function messages(): array
    {
        return [
            'name.required' => 'Укажите имя для бронирования.',
            'name.min' => 'Имя должно содержать не менее 2 символов.',
            'age.integer' => 'Возраст должен быть числом.',
            'age.min' => 'Возраст не может быть отрицательным.',
            'age.max' => 'Пожалуйста, укажите реальный возраст.',
            'number.required' => 'Укажите номер телефона.',
            'number.regex' => 'Введите номер телефона в формате +7 (999) 123-45-67.',
            'number_of_guests.required' => 'Укажите количество гостей.',
            'number_of_guests.min' => 'Количество гостей должно быть не меньше 1.',
            'check_in.required' => 'Укажите дату заезда.',
            'check_out.required' => 'Укажите дату выезда.',
            'check_out.after' => 'Дата выезда должна быть позже даты заезда.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->has('check_in') || $validator->errors()->has('check_out')) {
                    return;
                }

                $room = $this->route('room');

                if (!$room instanceof Room) {
                    return;
                }

                if (!Application::hasBookingConflict(
                    $room->id,
                    (string) $this->input('check_in'),
                    (string) $this->input('check_out'),
                )) {
                    return;
                }

                $validator->errors()->add(
                    'check_in',
                    'На выбранные даты этот номер уже забронирован или ожидает подтверждения. Пожалуйста, выберите другой период.'
                );
            },
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
