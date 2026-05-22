@extends('admin-theme')
@section('title', 'Заявка #' . $application->id)
@section('content')
    <div class="admin-application">
        <div class="admin-application__header">
            <h1 class="admin-application__title">Заявка #{{ $application->id }}</h1>
            <div class="admin-application__actions">
                <a href="{{ route('admin.applications.index') }}" class="admin-application__back-btn">
                    ← Назад
                </a>
                <a href="{{ route('rooms.show', $application->room) }}" target="_blank"
                   class="admin-application__room-link">
                    <i class="bi bi-box-arrow-up-right"></i>Открыть номер
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="admin-alert admin-alert--success">
                <span class="admin-alert__text">{{ session('success') }}</span>
                <button type="button" class="admin-alert__close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="admin-application__grid">
            {{-- Левая колонка: Информация --}}
            <div class="admin-application__main">

                {{-- Информация о бронировании --}}
                <div class="admin-card admin-card--info">
                    <div class="admin-card__header">
                        <h2 class="admin-card__title"> Информация о бронировании</h2>
                    </div>
                    <div class="admin-card__body">
                        <dl class="admin-details">
                            <div class="admin-details__row">
                                <dt class="admin-details__label">Номер</dt>
                                <dd class="admin-details__value">
                                    <span class="admin-details__room-name">{{ $application->room->name }}</span>
                                    <div class="admin-details__room-desc">{{ $application->room->description }}</div>
                                </dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Статус</dt>
                                <dd class="admin-details__value">
                                    <span class="admin-badge admin-badge--{{ $application->status }}">
                                        {{ $application->status->label() }}
                                    </span>
                                </dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Дата заезда</dt>
                                <dd class="admin-details__value">{{ $application->check_in->format('d.m.Y H:i') }}</dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Дата выезда</dt>
                                <dd class="admin-details__value">{{ $application->check_out->format('d.m.Y H:i') }}</dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Ночей</dt>
                                <dd class="admin-details__value">
                                    <span class="admin-badge admin-badge--neutral">
                                        {{ $application->check_in->diffInDays($application->check_out) }}
                                    </span>
                                </dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Гостей</dt>
                                <dd class="admin-details__value">{{ $application->number_of_guests }} чел.</dd>
                            </div>

                            @if($application->comment)
                                <div class="admin-details__row">
                                    <dt class="admin-details__label">Комментарий</dt>
                                    <dd class="admin-details__value admin-details__comment">{{ $application->comment }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Выбранные услуги --}}
                @if($application->services_count)
                    <div class="admin-card admin-card--services">
                        <div class="admin-card__header admin-card__header--with-badge">
                            <h2 class="admin-card__title">Дополнительные услуги</h2>
                            <span class="admin-badge admin-badge--info">
                                {{ $application->services_count }} шт.
                            </span>
                        </div>
                        <div class="admin-card__body admin-card__body--padded">
                            <div class="admin-table-wrapper">
                                <table class="admin-table admin-table--compact">
                                    <thead class="admin-table__head">
                                    <tr>
                                        <th class="admin-table__cell">Услуга</th>
                                        <th class="admin-table__cell">Цена</th>
                                    </tr>
                                    </thead>
                                    <tbody class="admin-table__body">
                                    @foreach($application->services as $service)
                                        <tr class="admin-table__row">
                                            <td class="admin-table__cell">
                                                <strong class="admin-table__service-name">{{ $service->name }}</strong>
                                                @if($service->description)
                                                    <span
                                                        class="admin-table__service-desc">{{ $service->description }}</span>
                                                @endif
                                            </td>
                                            <td class="admin-table__cell">{{ $service->formatted_price }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="admin-table__row admin-table__row--total">
                                        <td class="admin-table__cell admin-table__cell--total-label">Итого
                                            за услуги:
                                        </td>
                                        <td class="admin-table__cell admin-table__cell--total-value">{{ $application->services_sum_price }}
                                            ₽
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="admin-card admin-card--empty">
                        <div class="admin-empty-state">
                            <i class="bi bi-briefcase admin-empty-state__icon"></i>
                            <p class="admin-empty-state__text">Дополнительные услуги не выбраны</p>
                        </div>
                    </div>
                @endif

                {{-- Информация о госте --}}
                <div class="admin-card admin-card--guest">
                    <div class="admin-card__header">
                        <h2 class="admin-card__title">👤 Информация о госте</h2>
                    </div>
                    <div class="admin-card__body">
                        <dl class="admin-details">
                            <div class="admin-details__row">
                                <dt class="admin-details__label">Имя</dt>
                                <dd class="admin-details__value admin-details__value--bold">{{ $application->user->name }}</dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Возраст</dt>
                                <dd class="admin-details__value">{{ $application->user->age }} лет</dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Телефон</dt>
                                <dd class="admin-details__value admin-details__value--contacts">
                                    <a href="tel:{{ $application->user->phone }}" class="admin-link admin-link--phone">
                                        {{ $application->user->phone }}
                                    </a>
                                    <a
                                        href="https://wa.me/{{ $application->user->phone }}"
                                        target="_blank"
                                        class="admin-btn admin-btn--whatsapp"
                                    >
                                        WhatsApp
                                    </a>
                                </dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Создана</dt>
                                <dd class="admin-details__value admin-details__value--meta">{{ $application->created_at->format('d.m.Y H:i') }}</dd>
                            </div>

                            <div class="admin-details__row">
                                <dt class="admin-details__label">Обновлена</dt>
                                <dd class="admin-details__value admin-details__value--meta">{{ $application->updated_at->format('d.m.Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </div>

            {{-- Правая колонка: Действия --}}
            <div class="admin-application__sidebar">

                {{-- Статус --}}
                <div class="admin-card admin-card--status">
                    <div class="admin-card__header">
                        <h2 class="admin-card__title"> Управление статусом</h2>
                    </div>
                    <div class="admin-card__body">
                        <form
                            action="{{ route('admin.applications.update', $application) }}"
                            method="post"
                            class="admin-form"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="admin-form__field">
                                <label class="admin-form__label">Текущий статус</label>
                                @php
                                    $statusIcons = ['pending' => 'На рассмотрении', 'confirmed' => 'Подтверждено', 'cancelled' => 'Отменено'];
                                @endphp
                                <select name="status" class="admin-form__select" onchange="this.form.submit()">
                                    @foreach(\App\Enums\ApplicationStatusEnum::cases() as $status)
                                        <option
                                            value="{{ $status }}"
                                            @selected($status === $application->status)
                                        >
                                            {{ $statusIcons[$status->value] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        @if($application->status === \App\Enums\ApplicationStatusEnum::CONFIRMED)
                            <div class="admin-status-note admin-status-note--success">
                                <i class="bi bi-check-circle"></i>
                                Бронирование подтверждено
                            </div>
                        @elseif($application->status === \App\Enums\ApplicationStatusEnum::CANCELLED)
                            <div class="admin-status-note admin-status-note--danger">
                                <i class="bi bi-x-circle"></i>
                                Бронирование отменено
                            </div>
                        @else
                            <div class="admin-status-note admin-status-note--warning">
                                <i class="bi bi-hourglass-split"></i>
                                Ожидает подтверждения
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Контакты --}}
                <div class="admin-card admin-card--contacts">
                    <div class="admin-card__header">
                        <h2 class="admin-card__title"> Связаться с гостем</h2>
                    </div>
                    <div class="admin-card__body">
                        <div class="admin-contacts-grid">
                            <a href="tel:{{ $application->user->phone }}"
                               class="admin-btn admin-btn--outline admin-btn--phone-black">
                                Позвонить
                            </a>
                            <a href="https://wa.me/{{ $application->user->phone }}"
                               target="_blank"
                               class="admin-btn admin-btn--whatsapp">
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Опасная зона --}}
                <div class="admin-card admin-card--danger">
                    <div class="admin-card__header">
                        <h2 class="admin-card__title admin-card__title--danger">Удаление заявки</h2>
                    </div>
                    <div class="admin-card__body">
                        <p class="admin-card__warning">
                            Удаление заявки необратимо. Все данные будут потеряны.
                        </p>
                        <form
                            action="{{ route('admin.applications.destroy', $application) }}"
                            method="post"
                            class="admin-form"
                            onsubmit="return confirm('Вы уверены? Заявка будет удалена безвозвратно.')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="admin-btn admin-btn--danger admin-btn--full">
                                Удалить заявку
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
