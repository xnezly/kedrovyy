<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminMainController extends Controller
{
    // Дашборд
    public function index(): View
    {
        $applicationStatuses = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $applicationStatuses = array_replace([
            ApplicationStatusEnum::PENDING->value => 0,
            ApplicationStatusEnum::CONFIRMED->value => 0,
        ], $applicationStatuses);

        $recentApplications = Application::with(['user', 'room'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'applicationStatuses' => $applicationStatuses,
            'recentApplications' => $recentApplications,
            'statusEnum' => ApplicationStatusEnum::class,
            'usersCount' => User::count(),
            'servicesCount' => Service::count(),
        ]);
    }
}
