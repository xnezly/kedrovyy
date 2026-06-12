<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\CreateRequest;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoomController extends Controller
{
    // Вывод всех номеров
    public function index(): View
    {
        $rooms = Room::with('services')
            ->withCount('services')
            ->paginate(9);

        return view('rooms.index', ['rooms' => $rooms]);
    }

    // Просмотр номера
    public function show(Room $room): View
    {
        $room->load([
            'services',
            'images' => fn ($query) => $query->orderBy('images.id'),
        ]);
        $reviews = $room->reviews()->with('user')->latest()->get();
        $galleryImages = $room->images
            ->map(fn ($image, $index) => [
                'url' => $image->url,
                'alt' => $room->name . ' ' . ($index + 1),
            ])
            ->values();

        if ($galleryImages->isEmpty()) {
            $galleryImages = collect([
                [
                    'url' => '/img/photo.webp',
                    'alt' => $room->name,
                ],
            ]);
        }

        return view('rooms.show', [
            'room' => $room,
            'reviews' => $reviews,
            'galleryImages' => $galleryImages,
        ]);
    }

    // Комментарий
    public function comment(
        Room          $room,
        CreateRequest $request,
    ): RedirectResponse
    {
        $room->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('rooms.show', ['room' => $room]);
    }
}
