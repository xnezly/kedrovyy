<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminServiceController extends Controller
{
    // Вывод всех услуг
    public function index(): View
    {
        $services = Service::paginate(10);

        return view('admin.services.index', ['services' => $services]);
    }

    // Форма создания услуги
    public function create(): View
    {
        return view('admin.services.create');
    }

    // Создание новой услуги
    public function store(ServiceRequest $request): RedirectResponse
    {
        if ($request->hasFile('icon')) {
            $path = $this->uploadIcon($request->file('icon'));
        }

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'icon' => $path ?? null,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Услуга успешно добавлена');
    }

    // Форма редактирования услуги
    public function edit(Service $service): View
    {
        return view('admin.services.edit', ['service' => $service]);
    }

    // Обновление услуги
    public function update(
        Service        $service,
        ServiceRequest $request
    ): RedirectResponse
    {
        if ($request->hasFile('icon')) {
            $this->deleteIcon($service);
            $path = $this->uploadIcon($request->file('icon'));
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'icon' => $path ?? $service->icon,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Услуга обновлена');
    }

    // Удаление услуги
    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteIcon($service);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Услуга удалена');
    }

    // Загрузка иконки
    private function uploadIcon(UploadedFile $icon): string
    {
        $iconName = uniqid('service_') . '.' . $icon->extension();
        $folder = 'services';
        return $icon->storeAs($folder, $iconName, 'public');
    }

    // Удаление иконки
    private function deleteIcon(Service $service): void
    {
        if ($service->icon) Storage::disk('public')->delete($service->icon);
    }
}
