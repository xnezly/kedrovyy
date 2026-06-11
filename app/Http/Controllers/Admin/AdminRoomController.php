<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Image;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminRoomController extends Controller
{
    // Вывод всех номеров (сначала новые)
    public function index(): View
    {
        $rooms = Room::withCount('services')
            ->latest()
            ->paginate(10);

        return view('admin.rooms.index', ['rooms' => $rooms]);
    }

    // Форма создания номера
    public function create(): View
    {
        $services = Service::all();

        return view('admin.rooms.create', ['services' => $services]);
    }

    // Создание нового номера
    public function store(RoomRequest $request): RedirectResponse
    {
        $room = Room::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        if (!empty($request->services)) {
            $room->services()->attach($request->services);
        }

        if ($request->hasFile('images')) {
            $this->uploadImages($room, $request->images);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Номер успешно добавлен');
    }

    // Форма редактирования номера
    public function edit(Room $room): View
    {
        $services = Service::all();

        return view('admin.rooms.edit', [
            'room' => $room,
            'services' => $services,
        ]);
    }

    // Обновление номера
    public function update(
        Room        $room,
        RoomRequest $request
    ): RedirectResponse
    {
        $room->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $room->services()->sync($request->services ?? []);

        if ($request->hasFile('images')) {
            $this->deleteImages($room);
            $this->uploadImages($room, $request->images);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Номер обновлён');
    }

    // Удаление номера
    public function destroy(Room $room): RedirectResponse
    {
        $this->deleteImages($room);
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Номер удалён');
    }

    // Загрузка фотографий
    private function uploadImages(
        Room  $room,
        array $images
    ): void
    {
        $imageIds = [];

        foreach ($images as $image) {
            $folder = 'rooms';
            $imageName = uniqid('room_') . '.' . $image->extension();
            $image->storeAs($folder, $imageName, 'public');
            $path = $folder . '/' . $imageName;

            $imageIds[] = Image::create([
                'name' => $imageName,
                'path' => $path,
            ])->id;
        }

        $room->images()->attach($imageIds);
    }

    // Удаление фотографий
    private function deleteImages(Room $room): void
    {
        if ($room->images->isNotEmpty()) {
            foreach ($room->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }
    }
}
