<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['name' => 'Стандарт', 'description' => 'Уютный номер для одного или двух гостей.'],
            ['name' => 'Улучшенный', 'description' => 'Просторный номер с видом на город.'],
            ['name' => 'Люкс', 'description' => 'Номер повышенной комфортности с гостиной.'],
            ['name' => 'Семейный', 'description' => 'Двухкомнатный номер для семьи с детьми.'],
            ['name' => 'Президентский', 'description' => 'Роскошный номер с панорамным видом.'],
            ['name' => 'Эконом', 'description' => 'Бюджетный номер с кроватью и душем.'],
            ['name' => 'Стандарт Плюс', 'description' => 'Увеличенная площадь с рабочей зоной.'],
            ['name' => 'Комфорт', 'description' => 'Современный интерьер с ортопедическим матрасом.'],
            ['name' => 'Студия', 'description' => 'Открытое пространство с кухонным уголком.'],
            ['name' => 'Джуниор Люкс', 'description' => 'Переходный формат между стандартом и люксом.'],
            ['name' => 'Бизнес', 'description' => 'Номер с большим столом и скоростным интернетом.'],
            ['name' => 'Гранд Люкс', 'description' => 'Двухуровневый номер с камином.'],
            ['name' => 'Апартаменты', 'description' => 'Полноценная квартира с кухней и стиральной машиной.'],
            ['name' => 'Семейный Люкс', 'description' => 'Три спальные зоны и большая гостиная.'],
            ['name' => 'Номер для молодоженов', 'description' => 'Романтическая обстановка с джакузи.'],
            ['name' => 'Твин', 'description' => 'Две раздельные кровати для друзей или коллег.'],
            ['name' => 'Дабл', 'description' => 'Одна большая кровать King Size.'],
            ['name' => 'Сингл', 'description' => 'Компактный номер для одного путешественника.'],
            ['name' => 'Вид на море', 'description' => 'Балкон с прямым видом на водную гладь.'],
            ['name' => 'Вид на горы', 'description' => 'Живописный пейзаж из панорамного окна.'],
            ['name' => 'Вид на сад', 'description' => 'Тихий номер окнами в зеленый парк.'],
            ['name' => 'Угловой', 'description' => 'Панорамное остекление с двух сторон.'],
            ['name' => 'Мансарда', 'description' => 'Уютный номер под крышей с балками.'],
            ['name' => 'Лофт', 'description' => 'Стильный дизайн в индустриальном стиле.'],
            ['name' => 'Коттедж', 'description' => 'Отдельный домик с террасой и мангалом.'],
            ['name' => 'Вилла', 'description' => 'Роскошный дом с собственным бассейном.'],
            ['name' => 'Коннект', 'description' => 'Два смежных номера с внутренней дверью.'],
            ['name' => 'Антистресс', 'description' => 'Звукоизолированный номер с системой релаксации.'],
            ['name' => 'Пет-френдли', 'description' => 'Номер, адаптированный для проживания с животными.'],
            ['name' => 'Премиум', 'description' => 'Эксклюзивный сервис и дизайнерская мебель.'],
        ];

        foreach ($rooms as $data) {
            $room = Room::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => fake()->numberBetween(1000, 50000),
            ]);

            $imageIds = Image::inRandomOrder()->limit(rand(1, 5))->pluck('id');
            $serviceIds = Service::inRandomOrder()->limit(rand(1, Service::count()))->pluck('id');

            if ($imageIds->isNotEmpty()) {
                $room->images()->attach($imageIds);
            }

            if ($serviceIds->isNotEmpty()) {
                $room->services()->attach($serviceIds);
            }
        }
    }
}
