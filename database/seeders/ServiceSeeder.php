<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Wi-Fi', 'description' => 'Высокоскоростной беспроводной интернет на всей территории.'],
            ['name' => 'Кондиционер', 'description' => 'Индивидуальная система климат-контроля в номере.'],
            ['name' => 'Фен', 'description' => 'Профессиональный фен для ухода за волосами.'],
            ['name' => 'Чайник', 'description' => 'Электрический чайник с набором чая и кофе.'],
            ['name' => 'Телевизор', 'description' => 'Плоский экран с кабельными каналами.'],
            ['name' => 'Собственная ванная комната', 'description' => 'Ванная комната с душевой кабиной и туалетными принадлежностями.'],
            ['name' => 'Холодильник', 'description' => 'Мини-холодильник в номере для напитков и продуктов.'],
            ['name' => 'Парковка', 'description' => 'Охраняемая парковка для гостей отеля.'],
        ];

        foreach ($services as $data) {
            Service::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => fake()->numberBetween(100, 1000),
            ]);
        }
    }
}
