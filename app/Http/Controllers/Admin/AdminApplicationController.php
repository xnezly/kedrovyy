<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminApplicationController extends Controller
{
    // Вывод всех заявок (сначала новые)
    public function index(): View
    {
        $applications = Application::with('room')
            ->withCount('services')
            ->withSum('services', 'price')
            ->latest()
            ->paginate(10);

        return view('admin.applications.index', ['applications' => $applications]);
    }

    // Просмотр одной заявки
    public function show(Application $application): View
    {
        $application->load(['services', 'user'])
            ->loadCount('services')
            ->loadSum('services', 'price');

        return view('admin.applications.show', ['application' => $application]);
    }

    // Обновление статуса заявки
    public function update(
        Application              $application,
        UpdateApplicationRequest $request
    ): RedirectResponse
    {
        $application->update(['status' => $request->status]);

        return redirect()->back(fallback: route('admin.applications.index'));
    }

    // Удаление заявки
    public function destroy(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('admin.applications.index');
    }
}
