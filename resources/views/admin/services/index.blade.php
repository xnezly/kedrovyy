@extends('admin-theme')
@section('title', 'Услуги')
@section('content')
    <div class="admin-rooms">

        {{-- Заголовок --}}
        <div class="admin-rooms__header">
            <a href="{{ route('admin.dashboard') }}" class="admin-room-form__back-btn">
                ← На дашборд
            </a>
            <h1 class="admin-rooms__title">Управление услугами</h1>
            <a href="{{ route('admin.services.create') }}" class="admin-rooms__add-btn">
                <i class="bi bi-plus-circle"></i>Добавить услугу
            </a>
        </div>

        {{-- Уведомления --}}
        @if(session('success'))
            <div class="admin-alert admin-alert--success">
                <span class="admin-alert__text">{{ session('success') }}</span>
                <button type="button" class="admin-alert__close" aria-label="Закрыть">&times;</button>
            </div>
        @endif

        {{-- Таблица услуг --}}
        <div class="admin-rooms__card">
            <div class="admin-rooms__table-wrapper">
                <table class="admin-rooms__table">
                    <thead class="admin-rooms__table-head">
                    <tr>
                        <th class="admin-rooms__cell">ID</th>
                        <th class="admin-rooms__cell">Фото</th>
                        <th class="admin-rooms__cell">Название</th>
                        <th class="admin-rooms__cell">Описание</th>
                        <th class="admin-rooms__cell">Цена</th>
                        <th class="admin-rooms__cell admin-rooms__cell--actions">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="admin-rooms__table-body">
                    @forelse($services as $service)
                        <tr class="admin-rooms__row">
                            <td class="admin-rooms__cell admin-rooms__cell--id">{{ $service->id }}</td>

                            <td class="admin-rooms__cell">
                                @if($service->icon)
                                    <img src="{{ $service->icon_url }}"
                                         alt="{{ $service->name }}"
                                         class="admin-rooms__image">
                                @else
                                    <div class="admin-rooms__image-placeholder">
                                        <span class="admin-rooms__empty">Нет</span>
                                    </div>
                                @endif
                            </td>

                            <td class="admin-rooms__cell admin-rooms__cell--name">
                                {{ $service->name }}
                            </td>

                            <td class="admin-rooms__cell admin-rooms__cell--desc">
                                {{ $service->description }}
                            </td>

                            <td class="admin-rooms__cell admin-rooms__cell--price">
                                {{ $service->formatted_price }}
                            </td>

                            <td class="admin-rooms__cell admin-rooms__cell--actions">
                                <div class="admin-rooms__actions">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="admin-rooms__btn admin-rooms__btn--view"
                                       title="Редактировать">
                                        Редактировать
                                    </a>

                                    <form action="{{ route('admin.services.destroy', $service) }}"
                                          method="POST"
                                          class="admin-rooms__form"
                                          onsubmit="return confirm('Удалить услугу?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="admin-rooms__btn admin-rooms__btn--delete"
                                                title="Удалить">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="admin-rooms__row admin-rooms__row--empty">
                            <td colspan="8" class="admin-rooms__empty-cell">
                                <div class="admin-empty-state">
                                    <i class="bi bi-inbox admin-empty-state__icon"></i>
                                    <p class="admin-empty-state__text">Услуги не добавлены</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Пагинация --}}
            <div class="admin-rooms__pagination">
                {{ $services->links() }}
            </div>
        </div>
    </div>
@endsection
