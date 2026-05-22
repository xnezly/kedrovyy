@extends('admin-theme')
@section('title', 'Заявки')
@section('content')
    <div class="admin-bookings">
        <div class="admin-bookings__header">
            <h1 class="admin-bookings__title">Заявки на бронирование</h1>
            <a href="{{ route('admin.dashboard') }}" class="admin-bookings__back-btn">
                ← На дашборд
            </a>
        </div>

        @if(session('success'))
            <div class="admin-alert admin-alert--success">
                <span class="admin-alert__text">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </span>
                <button type="button" class="admin-alert__close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Фильтры --}}
        <div class="admin-filters">
            <form method="get" class="admin-filters__form">
                <div class="admin-filters__row">
                    <div class="admin-filters__col">
                        <label class="admin-filters__label">Статус</label>
                        <select name="status" class="admin-filters__select" onchange="this.form.submit()">
                            <option value="">Все статусы</option>
                            @foreach(\App\Enums\ApplicationStatusEnum::cases() as $status)
                                <option value="{{ $status }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-filters__col">
                        <label class="admin-filters__label">Дата заезда от</label>
                        <input type="date" name="date_from" class="admin-filters__input"
                               value="{{ request('date_from') }}" onchange="this.form.submit()">
                    </div>

                    <div class="admin-filters__col">
                        <label class="admin-filters__label">Дата заезда до</label>
                        <input type="date" name="date_to" class="admin-filters__input" value="{{ request('date_to') }}"
                               onchange="this.form.submit()">
                    </div>

                    <div class="admin-filters__col">
                        <label class="admin-filters__label">Поиск</label>

                        <div class="admin-filters__search">
                            <input type="text" name="search" class="admin-filters__search-input"
                                   placeholder="Имя или телефон" value="{{ request('search') }}">
                            <button type="submit" class="admin-filters__search-btn">Найти</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Таблица заявок --}}
        <div class="admin-table-card">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead class="admin-table__head">
                    <tr>
                        <th class="admin-table__cell admin-table__cell--index">№</th>
                        <th class="admin-table__cell">Номер</th>
                        <th class="admin-table__cell">Дата заезда</th>
                        <th class="admin-table__cell">Дата выезда</th>
                        <th class="admin-table__cell">Ночей</th>
                        <th class="admin-table__cell">Услуги</th>
                        <th class="admin-table__cell">Гостей</th>
                        <th class="admin-table__cell">Статус</th>
                        <th class="admin-table__cell">Дата создания</th>
                        <th class="admin-table__cell admin-table__cell--actions">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="admin-table__body">
                    @forelse($applications as $application)
                        <tr class="admin-table__row">
                            <td class="admin-table__cell admin-table__cell--index">
                                <span class="admin-table__id">#{{ $application->id }}</span>
                            </td>
                            <td class="admin-table__cell">
                                <a href="{{ route('rooms.show', $application->room) }}" class="admin-table__link"
                                   target="_blank">
                                    {{ $application->room->name }}
                                </a>
                            </td>
                            <td class="admin-table__cell">
                                <div class="admin-table__datetime">
                                    <span class="admin-table__date">{{ $application->check_in->format('d.m.Y') }}</span>
                                    <span class="admin-table__time">{{ $application->check_in->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="admin-table__cell">
                                <div class="admin-table__datetime">
                                    <span
                                        class="admin-table__date">{{ $application->check_out->format('d.m.Y') }}</span>
                                    <span class="admin-table__time">{{ $application->check_out->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="admin-table__cell">
                                <span class="admin-badge">
                                    {{ $application->check_in->diffInDays($application->check_out) }}
                                </span>
                            </td>
                            <td class="admin-table__cell">
                                @if($application->services_count)
                                    <div class="admin-table__services">
                                        <span class="admin-badge admin-badge--info">
                                            {{ $application->services_count }} шт.
                                        </span>
                                        <span class="admin-table__price">
                                            {{ $application->services_sum_price }} ₽
                                        </span>
                                    </div>
                                @else
                                    <span class="admin-table__empty">—</span>
                                @endif
                            </td>
                            <td class="admin-table__cell">{{ $application->count }}</td>
                            <td class="admin-table__cell">
                                <span class="admin-badge admin-badge--{{ $application->status }}">
                                    {{ $application->status->label() }}
                                </span>
                            </td>
                            <td class="admin-table__cell">
                                <small class="admin-table__created">
                                    {{ $application->created_at->format('d.m.Y') }}<br>
                                    {{ $application->created_at->format('H:i') }}
                                </small>
                            </td>
                            <td class="admin-table__cell admin-table__cell--actions">
                                <div class="admin-actions">
                                    <a href="{{ route('admin.applications.show', $application) }}"
                                       class="admin-rooms__btn admin-rooms__btn--view"
                                       title="Просмотр">
                                        Просмотр
                                    </a>

                                    {{-- Смена статуса --}}
                                    <form action="{{ route('admin.applications.update', $application) }}" method="POST"
                                          class="admin-actions__form">
                                        @csrf
                                        @php
                                            $statusIcons = ['pending' => 'На рассмотрении', 'confirmed' => 'Подтерждено', 'cancelled' => 'Отменено'];
                                        @endphp
                                        <select name="status" class="admin-actions__select"
                                                onchange="this.form.submit()" title="Изменить статус">
                                            @foreach(\App\Enums\ApplicationStatusEnum::cases() as $status)
                                                <option
                                                    value="{{ $status }}"
                                                    @selected($status === $application->status)
                                                >
                                                    {{ $statusIcons[$status->value] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>

                                    {{-- Удаление --}}
                                    <form action="{{ route('admin.applications.destroy', $application) }}"
                                          method="post"
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
                        <tr class="admin-table__row admin-table__row--empty">
                            <td colspan="10" class="admin-table__empty-cell">
                                <div class="admin-empty-state">
                                    <i class="bi bi-inbox admin-empty-state__icon"></i>
                                    <p class="admin-empty-state__text">Заявок не найдено</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $applications->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
