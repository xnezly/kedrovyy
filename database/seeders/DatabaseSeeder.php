<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'phone' => '70000000000',
            'name' => 'admin',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);

        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            RoomSeeder::class,
        ]);

        Application::factory(50)
            ->create()
            ->each(function (Application $application) {
                $serviceIds = Service::inRandomOrder()
                    ->limit(rand(1, Service::count()))
                    ->pluck('id');

                $application->services()->attach($serviceIds);
            });
    }
}
