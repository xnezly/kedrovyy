<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatusEnum;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    // Главная страница с номерами
    public function index(): View
    {
        $rooms = Room::with('services')
            ->withCount('services')
            ->limit(6)
            ->get();

        return view('index', ['rooms' => $rooms]);
    }

    // Страница описания
    public function about(): View
    {
        return view('about');
    }

    // Страница контактов
    public function contacts(): View
    {
        return view('contacts');
    }

    // Страница бронирования
    public function booking(Request $request): View
    {
        $today = now()->startOfDay();
        $defaultCheckIn = $today->copy()->addDay();

        $checkIn = $request->date('check_in');
        $checkOut = $request->date('check_out');

        if (!$checkIn || $checkIn->lt($today)) {
            $checkIn = $defaultCheckIn->copy();
        } else {
            $checkIn = $checkIn->startOfDay();
        }

        if (!$checkOut || !$checkOut->gt($checkIn)) {
            $checkOut = $checkIn->copy()->addDay();
        } else {
            $checkOut = $checkOut->startOfDay();
        }

        $nights = $checkIn->diffInDays($checkOut);

        $rooms = Room::with('services')
            ->withCount('services')
            ->whereDoesntHave('applications', function (Builder $query) use ($checkIn, $checkOut) {
                $query->where('status', '!=', ApplicationStatusEnum::CANCELLED->value)
                    ->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->get();

        return view('booking', [
            'rooms' => $rooms,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nights' => $nights,
        ]);
    }
}
