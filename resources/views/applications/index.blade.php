@extends('theme')
@section('title', 'Личный кабинет')
@section('content')
    <div class="dashboard">
        <div class="dashboard__container">
            <div class="dashboard__card">

                {{-- Уведомления --}}
                @if(session('success'))
                    <div class="dashboard-alert dashboard-alert--success" role="alert">
                        <span class="dashboard-alert__text">
                            <i class="bi bi-check-circle"></i>{{ session('success') }}
                        </span>
                        <button type="button" class="dashboard-alert__close" aria-label="Закрыть">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="dashboard-alert dashboard-alert--error" role="alert">
                        <span class="dashboard-alert__text">
                            <i class="bi bi-exclamation-triangle"></i>{{ session('error') }}
                        </span>
                        <button type="button" class="dashboard-alert__close" aria-label="Закрыть">&times;</button>
                    </div>
                @endif

                {{-- Заголовок --}}
                <div class="dashboard__header">
                    <div class="dashboard__title-wrapper">
                        <h1 class="dashboard__title">Личный кабинет</h1>
                        <p class="dashboard__user">
                            <i class="bi bi-person"></i> {{ auth()->user()->name }}
                        </p>
                    </div>
                </div>

                {{-- Статистика --}}
                <div class="dashboard-stats">
                    <div class="dashboard-stats__item dashboard-stats__item--confirmed">
                        <div class="dashboard-stats__icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="dashboard-stats__value">
                            {{ $applicationStatuses[$statusEnum::CONFIRMED->value] ?? 0 }}
                        </div>
                        <div class="dashboard-stats__label">Подтверждено</div>
                    </div>

                    <div class="dashboard-stats__item dashboard-stats__item--pending">
                        <div class="dashboard-stats__icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="dashboard-stats__value">
                            {{ $applicationStatuses[$statusEnum::PENDING->value] ?? 0 }}
                        </div>
                        <div class="dashboard-stats__label">На рассмотрении</div>
                    </div>

                    <div class="dashboard-stats__item dashboard-stats__item--total">
                        <div class="dashboard-stats__icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="dashboard-stats__value">
                            {{ $applicationCount }}
                        </div>
                        <div class="dashboard-stats__label">Всего заявок</div>
                    </div>
                </div>

                {{-- Таблица заявок --}}
                <div class="dashboard-section">
                    <h2 class="dashboard-section__title">Мои бронирования</h2>

                    @if($applicationCount > 0)
                        <div class="dashboard-table-wrapper">
                            <table class="dashboard-table">
                                <thead class="dashboard-table__head">
                                <tr>
                                    <th class="dashboard-table__cell">№</th>
                                    <th class="dashboard-table__cell">Номер</th>
                                    <th class="dashboard-table__cell">Дата заезда</th>
                                    <th class="dashboard-table__cell">Дата выезда</th>
                                    <th class="dashboard-table__cell">Ночей</th>
                                    <th class="dashboard-table__cell">Услуги</th>
                                    <th class="dashboard-table__cell">Гостей</th>
                                    <th class="dashboard-table__cell">Статус</th>
                                    <th class="dashboard-table__cell">Дата создания</th>
                                    <th class="dashboard-table__cell dashboard-table__cell--actions">Действия</th>
                                </tr>
                                </thead>
                                <tbody class="dashboard-table__body">
                                @foreach($applications as $application)
                                    <tr class="dashboard-table__row">
                                        <td class="dashboard-table__cell dashboard-table__cell--id">
                                            #{{ $application->id }}</td>
                                        <td class="dashboard-table__cell">
                                            <a href="{{ route('rooms.show', $application->room) }}"
                                               class="dashboard-table__link" target="_blank">
                                                {{ $application->room->name }}
                                            </a>
                                        </td>
                                        <td class="dashboard-table__cell">
                                            <div class="dashboard-table__date">
                                                {{ $application->check_in->format('d.m.Y') }}
                                            </div>
                                        </td>
                                        <td class="dashboard-table__cell">
                                            <div class="dashboard-table__date">
                                                {{ $application->check_out->format('d.m.Y') }}
                                            </div>
                                        </td>
                                        <td class="dashboard-table__cell">
                                            @if($application->check_in && $application->check_out)
                                                <span class="dashboard-badge">
                                                    {{ $application->check_in->diffInDays($application->check_out) }}
                                                </span>
                                            @else
                                                <span class="dashboard-table__empty">—</span>
                                            @endif
                                        </td>
                                        <td class="dashboard-table__cell">
                                            @if($application->services_count)
                                                <div class="dashboard-table__services">
                                                    <span class="dashboard-badge dashboard-badge--info">
                                                        {{ $application->services_count }} шт.
                                                    </span>
                                                    <span class="dashboard-table__price">
                                                        {{ $application->services_sum_price }} ₽
                                                    </span>
                                                </div>
                                            @else
                                                <span class="dashboard-table__empty">—</span>
                                            @endif
                                        </td>
                                        <td class="dashboard-table__cell">{{ $application->number_of_guests }}</td>
                                        <td class="dashboard-table__cell">
                                                <span
                                                    class="dashboard-badge dashboard-badge--{{ $application->status }}">
                                                    {{ $application->status->label() }}
                                                </span>
                                        </td>
                                        <td class="dashboard-table__cell dashboard-table__cell--meta">
                                            {{ $application->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="dashboard-table__cell dashboard-table__cell--actions">
                                            <div class="dashboard-actions">
                                                <button
                                                    type="button"
                                                    class="dashboard-actions__btn dashboard-actions__btn--view"
                                                    data-modal-open="detailModal{{ $application->id }}"
                                                    title="Подробности"
                                                ></button>

                                                @if($application->status === $statusEnum::PENDING)
                                                    <button
                                                        type="button"
                                                        class="dashboard-actions__btn dashboard-actions__btn--cancel"
                                                        data-confirm-cancel
                                                        data-action="{{ route('applications.cancel', $application) }}"
                                                        data-app-name="{{ $application->room->name ?? 'Заявка #' . $application->id }}"
                                                        title="Отменить"
                                                    ></button>
                                                @else
                                                    <span
                                                        class="dashboard-actions__empty"
                                                        title="Нельзя отменить"
                                                    >
                                                        —
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Пагинация --}}
                        <div class="dashboard-pagination">
                            {{ $applications->links() }}
                        </div>
                    @else
                        {{-- Пустое состояние --}}
                        <div class="dashboard-empty">
                            <div class="dashboard-empty__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                                     viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                            </div>
                            <h3 class="dashboard-empty__title">У вас пока нет бронирований</h3>
                            <p class="dashboard-empty__text">Выберите номер и забронируйте его для отдыха</p>
                            <a href="{{ route('rooms.index') }}" class="dashboard-empty__btn">
                                <i class="bi bi-plus-circle"></i>Выбрать номер
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- МОДАЛЬНЫЕ ОКНА (кастомные, без Bootstrap) --}}
    @foreach($applications as $application)
        {{-- Модальное окно: детали заявки --}}
        <div class="modal" id="detailModal{{ $application->id }}" aria-hidden="true" role="dialog"
             aria-labelledby="detailModalTitle{{ $application->id }}">
            <div class="modal__overlay" data-modal-close></div>
            <div class="modal__dialog modal__dialog--lg">
                <div class="modal__content">
                    <div class="modal__header">
                        <h3 class="modal__title" id="detailModalTitle{{ $application->id }}">Заявка
                            #{{ $application->id }}</h3>
                        <button type="button" class="modal__close" data-modal-close aria-label="Закрыть">&times;
                        </button>
                    </div>
                    <div class="modal__body">
                        <div class="modal__grid">
                            <div class="modal__col">
                                <h4 class="modal__subtitle">📋 Информация о бронировании</h4>
                                <dl class="modal-details">
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Номер</dt>
                                        <dd class="modal-details__value">{{ $application->room->name }}</dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Статус</dt>
                                        <dd class="modal-details__value">
                                            <span class="dashboard-badge dashboard-badge--{{ $application->status }}">
                                                {{ $application->status->label() }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Заезд</dt>
                                        <dd class="modal-details__value">{{ $application->check_in->format('d.m.Y H:i') }}</dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Выезд</dt>
                                        <dd class="modal-details__value">{{ $application->check_out->format('d.m.Y H:i') }}</dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Ночей</dt>
                                        <dd class="modal-details__value">
                                            {{ $application->check_in->diffInDays($application->check_out) }}
                                        </dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Гостей</dt>
                                        <dd class="modal-details__value">{{ $application->number_of_guests }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="modal__col">
                                <h4 class="modal__subtitle">👤 Информация о госте</h4>
                                <dl class="modal-details">
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Имя</dt>
                                        <dd class="modal-details__value modal-details__value--bold">{{ $application->user->name }}</dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Возраст</dt>
                                        <dd class="modal-details__value">{{ $application->user->age }} лет</dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Телефон</dt>
                                        <dd class="modal-details__value">
                                            <p class="modal-details__link">{{ $application->user->phone }}</p>
                                        </dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Создана</dt>
                                        <dd class="modal-details__value">{{ $application->created_at->format('d.m.Y H:i') }}</dd>
                                    </div>
                                    <div class="modal-details__row">
                                        <dt class="modal-details__label">Обновлена</dt>
                                        <dd class="modal-details__value">{{ $application->updated_at->format('d.m.Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        @if($application->comment)
                            <div class="modal__comment">
                                <h4 class="modal__comment-title">💬 Комментарий</h4>
                                <p class="modal__comment-text">{{ $application->comment }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="modal__footer">
                        <button type="button" class="btn btn--outline-pill" data-modal-close>Закрыть</button>
                        @if($application->status === $statusEnum::PENDING)
                            <button
                                type="button"
                                class="btn btn--danger btn--rounded"
                                data-confirm-cancel
                                data-action="{{ route('applications.cancel', $application) }}"
                                data-app-name="{{ $application->room->name ?? 'Заявка #' . $application->id }}"
                            >
                                Отменить бронирование
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Модальное окно: услуги --}}
        @if($application->services_count)
            <div
                class="modal" id="servicesModal{{ $application->id }}"
                aria-hidden="true"
                role="dialog"
                aria-labelledby="servicesModalTitle{{ $application->id }}"
            >
                <div class="modal__overlay" data-modal-close></div>

                <div class="modal__dialog">
                    <div class="modal__content">
                        <div class="modal__header">
                            <h3 class="modal__title" id="servicesModalTitle{{ $application->id }}">🎁 Дополнительные
                                услуги</h3>
                            <button type="button" class="modal__close" data-modal-close aria-label="Закрыть">&times;
                            </button>
                        </div>

                        <div class="modal__body">
                            <div class="modal-table-wrapper">
                                <table class="modal-table">
                                    <thead class="modal-table__head">
                                    <tr>
                                        <th class="modal-table__cell">Услуга</th>
                                        <th class="modal-table__cell">Цена</th>
                                        <th class="modal-table__cell">Кол-во</th>
                                        <th class="modal-table__cell modal-table__cell--total">Сумма</th>
                                    </tr>
                                    </thead>
                                    <tbody class="modal-table__body">
                                    @foreach($application->services as $service)
                                        <tr class="modal-table__row">
                                            <td class="modal-table__cell">
                                                <strong class="modal-table__service-name">{{ $service->name }}</strong>
                                                @if($service->description)
                                                    <span
                                                        class="modal-table__service-desc">{{ $service->description }}</span>
                                                @endif
                                            </td>
                                            <td class="modal-table__cell">{{ $service->formatted_price }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="modal-table__row modal-table__row--total">
                                        <td colspan="3" class="modal-table__cell modal-table__cell--total-label">
                                            Итого:
                                        </td>
                                        <td class="modal-table__cell modal-table__cell--total-value modal-table__cell--grand-total">
                                            {{ $application->services_sum_price }} ₽
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal__footer">
                            <button type="button" class="btn btn--outline-pill" data-modal-close>Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Подключение скрипта --}}
    <script src="{{ asset('js/cabinet.js') }}"></script>
@endsection
