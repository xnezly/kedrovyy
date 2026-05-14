@extends('admin-theme')
@section('content')
    <div class="admin-dashboard">

        {{-- Заголовок --}}
        <div class="admin-dashboard__header">
            <h1 class="admin-dashboard__title">Дашборд</h1>
            <div class="admin-dashboard__datetime">{{ now()->format('d.m.Y H:i') }}</div>
        </div>

        {{-- Статистика --}}
        <div class="admin-stats">
            <div class="admin-stat-card admin-stat-card--success">
                <div class="admin-stat-card__icon">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <div class="admin-stat-card__value">
                    {{ $applicationStatuses[$statusEnum::CONFIRMED->value] }}
                </div>

                <div class="admin-stat-card__label">Подтверждено</div>
            </div>

            <div class="admin-stat-card admin-stat-card--warning">
                <div class="admin-stat-card__icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div class="admin-stat-card__value">
                    {{ $applicationStatuses[$statusEnum::PENDING->value] }}
                </div>

                <div class="admin-stat-card__label">На рассмотрении</div>
            </div>

            <div class="admin-stat-card admin-stat-card--info">
                <div class="admin-stat-card__icon">
                    <i class="bi bi-people"></i>
                </div>

                <div class="admin-stat-card__value">{{ $usersCount }}</div>
                <div class="admin-stat-card__label">Пользователей</div>
            </div>

            <div class="admin-stat-card admin-stat-card--primary">
                <div class="admin-stat-card__icon">
                    <i class="bi bi-briefcase"></i>
                </div>

                <div class="admin-stat-card__value">{{ $servicesCount }}</div>
                <div class="admin-stat-card__label">Услуг</div>
            </div>
        </div>

        {{-- Последние бронирования --}}
        <div class="admin-dashboard__section">
            <div class="admin-recent-table">
                <div class="admin-recent-table__header">
                    <h2 class="admin-recent-table__title">Последние бронирования</h2>
                    <a href="{{ route('admin.applications.index') }}" class="admin-recent-table__link">
                        Все заявки
                    </a>
                </div>

                <div class="admin-recent-table__body">
                    <div class="admin-recent-table__wrapper">
                        <table class="admin-recent-table__table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Гость</th>
                                <th>Номер</th>
                                <th>Даты</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recentApplications as $application)
                                <tr>
                                    <td>#{{ $application->id }}</td>
                                    <td>
                                        <div class="admin-recent-table__guest">
                                            <span
                                                class="admin-recent-table__guest-name">{{ $application->user->name }}</span>
                                            <span
                                                class="admin-recent-table__guest-phone">{{ $application->user->phone }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $application->room->name }}</td>
                                    <td class="admin-recent-table__dates">
                                        {{ $application->check_in->format('d.m') }}
                                        - {{ $application->check_out->format('d.m.Y') }}
                                    </td>
                                    <td>
                                        <span class="admin-badge admin-badge--{{ $application->status }}">
                                            {{ $application->status->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('admin.applications.show', $application) }}"
                                            class="admin-btn admin-btn--outline admin-btn--sm"
                                        >
                                            Просмотреть
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="admin-recent-table__empty">
                                        Нет бронирований
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Быстрые действия --}}
        <div class="admin-dashboard__section">
            <div class="admin-quick-actions">
                <div class="admin-quick-actions__header">
                    <h2 class="admin-quick-actions__title">Быстрые действия</h2>
                </div>

                <div class="admin-quick-actions__body">
                    <div class="admin-quick-actions__grid">
                        <a
                            href="{{ route('admin.services.create') }}"
                            class="admin-quick-actions__btn admin-quick-actions__btn--success"
                        >
                            <i class="bi bi-plus-circle"></i>Добавить услугу
                        </a>

                        <a
                            href="{{ route('admin.applications.index') }}"
                            class="admin-quick-actions__btn admin-quick-actions__btn--outline"
                        >
                            <i class="bi bi-list-check"></i>Просмотреть все заявки
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
