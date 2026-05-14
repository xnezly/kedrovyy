<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Иван Петров', 'phone' => '79001112233'],
            ['name' => 'Мария Сидорова', 'phone' => '79004445566'],
            ['name' => 'Алексей Смирнов', 'phone' => '79007778899'],
            ['name' => 'Елена Козлова', 'phone' => '79001234567'],
            ['name' => 'Дмитрий Новиков', 'phone' => '79009876543'],
            ['name' => 'Ольга Морозова', 'phone' => '79005556677'],
            ['name' => 'Сергей Волков', 'phone' => '79003332211'],
            ['name' => 'Анна Лебедева', 'phone' => '79008889900'],
            ['name' => 'Павел Соколов', 'phone' => '79006665544'],
        ];

        foreach ($users as $data) {
            User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'password' => Hash::make('user123'),
            ]);
        }
    }
}
