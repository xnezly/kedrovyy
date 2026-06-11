<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatusEnum;
use App\Http\Requests\Applications\CreateApplicationRequest;
use App\Models\Application;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    // Вывод всех заявок
    public function index(): View
    {
        $applications = auth()->user()
            ->applications()
            ->with(['room', 'user', 'services'])
            ->withCount('services')
            ->withSum('services', 'price')
            ->latest()
            ->paginate(10);

        $applicationStatuses = auth()->user()
            ->applications()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $applicationStatuses = array_replace([
            ApplicationStatusEnum::PENDING->value => 0,
            ApplicationStatusEnum::CONFIRMED->value => 0,
            ApplicationStatusEnum::CANCELLED->value => 0,
        ], $applicationStatuses);

        return view('applications.index', [
            'applications' => $applications,
            'applicationStatuses' => $applicationStatuses,
            'statusEnum' => ApplicationStatusEnum::class,
            'applicationCount' => auth()->user()->applications()->count(),
        ]);
    }

    // Форма создания заявки
    public function create(Room $room): View
    {
        $services = Service::all();

        return view('applications.create', [
            'room' => $room,
            'services' => $services,
        ]);
    }

    // Создание заявки
    public function store(
        Room                     $room,
        CreateApplicationRequest $request
    ): RedirectResponse
    {
        $application = auth()->user()->applications()->create([
            'room_id' => $room->id,
            'number_of_guests' => $request->number_of_guests,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'comment' => $request->comment,
        ]);

        if ($request->services) {
            $application->services()->attach($request->services);
        }

        return redirect()->route('home');
    }

    // Отмена заявки
    public function cancel(Application $application): RedirectResponse
    {
        if ($application->user_id !== auth()->user()->id) {
            return redirect()->route('applications.index')->with('error', 'Невозможно отменить');
        }

        if ($application->status === ApplicationStatusEnum::CONFIRMED) {
            return redirect()->route('applications.index')->with('error', 'Невозможно отменить подтверждённое бронирование');
        }

        $application->update(['status' => ApplicationStatusEnum::CANCELLED]);

        return redirect()->route('applications.index')->with('success', 'Бронирование отменено');
    }
}
