<?php

namespace Database\Factories;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        $checkIn = Carbon::today()->addDays($this->faker->numberBetween(1, 30));
        $checkOut = $checkIn->clone()->addDays($this->faker->numberBetween(1, 14));

        return [
            'number_of_guests' => $this->faker->numberBetween(1, 5),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'comment' => $this->faker->text(),
            'status' => ApplicationStatusEnum::cases()[array_rand(ApplicationStatusEnum::cases())],
            'user_id' => User::where('is_admin', false)->inRandomOrder()->first()->id,
            'room_id' => Room::inRandomOrder()->first()->id,
        ];
    }
}
