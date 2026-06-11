<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminApplicationController extends Controller
{
    public function index(): View
    {
        $applications = Application::with('room')
            ->withCount('services')
            ->withSum('services', 'price')
            ->latest()
            ->paginate(10);

        return view('admin.applications.index', ['applications' => $applications]);
    }

    public function show(Application $application): View
    {
        $application->load(['services', 'user'])
            ->loadCount('services')
            ->loadSum('services', 'price');

        $application->syncContactSnapshotToUser();

        return view('admin.applications.show', ['application' => $application]);
    }

    public function update(
        Application $application,
        UpdateApplicationRequest $request,
    ): RedirectResponse {
        $status = ApplicationStatusEnum::from((string) $request->input('status'));
        $deletedConflictsCount = 0;

        DB::transaction(function () use ($application, $status, &$deletedConflictsCount): void {
            if ($status === ApplicationStatusEnum::CONFIRMED) {
                $conflictingApplications = Application::query()
                    ->where('room_id', $application->room_id)
                    ->whereKeyNot($application->id)
                    ->whereNotIn('status', [
                        ApplicationStatusEnum::CANCELLED->value,
                        ApplicationStatusEnum::CONFIRMED->value,
                    ])
                    ->overlapping($application->check_in, $application->check_out)
                    ->get();

                $deletedConflictsCount = $conflictingApplications->count();

                $conflictingApplications->each->delete();
            }

            $application->update(['status' => $status]);
        });

        $message = 'Статус заявки обновлен.';

        if ($status === ApplicationStatusEnum::CONFIRMED && $deletedConflictsCount > 0) {
            $message = 'Заявка подтверждена. Пересекающиеся заявки по этому номеру были автоматически удалены.';
        }

        return redirect()
            ->back(fallback: route('admin.applications.index'))
            ->with('success', $message);
    }

    public function destroy(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('admin.applications.index');
    }
}
