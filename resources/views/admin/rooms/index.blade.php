@extends('admin-theme')
@section('title', 'Номера')
@section('content')
    <div class="admin-rooms">

        {{-- Заголовок --}}
        <div class="admin-rooms__header">
            <h1 class="admin-rooms__title">Управление номерами</h1>
            <a href="{{ route('admin.rooms.create') }}" class="admin-rooms__add-btn">
                <i class="bi bi-plus-circle"></i>Добавить номер
            </a>
        </div>

        {{-- Уведомления --}}
        @if(session('success'))
            <div class="admin-alert admin-alert--success">
                <span class="admin-alert__text">{{ session('success') }}</span>
                <button type="button" class="admin-alert__close" aria-label="Закрыть">&times;</button>
            </div>
        @endif

        {{-- Таблица номеров --}}
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
                        <th class="admin-rooms__cell">Удобства</th>
                        <th class="admin-rooms__cell admin-rooms__cell--actions">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="admin-rooms__table-body">
                    @forelse($rooms as $room)
                        <tr class="admin-rooms__row">
                            <td class="admin-rooms__cell admin-rooms__cell--id">#{{ $room->id }}</td>
                            <td class="admin-rooms__cell">
                                @if($room->images->isNotEmpty())
                                    <img
                                        src="{{ $room->image_url }}"
                                        alt="{{ $room->name }}"
                                        class="admin-rooms__image"
                                    >
                                @else
                                    <div class="admin-rooms__image-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="admin-rooms__cell admin-rooms__cell--name">
                                {{ $room->name }}
                            </td>
                            <td class="admin-rooms__cell admin-rooms__cell--desc">
                                {{ $room->description ?? '—' }}
                            </td>
                            <td class="admin-rooms__cell admin-rooms__cell--price">
                                {{ $room->formatted_price }}
                            </td>
                            <td class="admin-rooms__cell">
                                @if($room->services_count)
                                    <span class="admin-badge admin-badge--info">
                                            {{ $room->services_count }} шт.
                                        </span>
                                @else
                                    <span class="admin-rooms__empty">—</span>
                                @endif
                            </td>
                            <td class="admin-rooms__cell admin-rooms__cell--actions">
                                <div class="admin-rooms__actions">
                                    <a
                                        href="{{ route('rooms.show', $room) }}"
                                        class="admin-rooms__btn admin-rooms__btn--view"
                                        target="_blank"
                                        title="Просмотр на сайте"
                                    >
                                        Просмотреть
                                    </a>

                                    <a
                                        href="{{ route('admin.rooms.edit', $room) }}"
                                        class="admin-rooms__btn admin-rooms__btn--edit"
                                        title="Редактировать"
                                    >
                                        Редактировать
                                    </a>

                                    <form
                                        action="{{ route('admin.rooms.destroy', $room) }}"
                                        method="post"
                                        class="admin-rooms__form"
                                        onsubmit="return confirm('Удалить номер?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="admin-rooms__btn admin-rooms__btn--delete"
                                            title="Удалить"
                                        >
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="admin-rooms__row admin-rooms__row--empty">
                            <td colspan="7" class="admin-rooms__empty-cell">
                                <div class="admin-empty-state">
                                    <i class="bi bi-inbox admin-empty-state__icon"></i>
                                    <p class="admin-empty-state__text">Номера не добавлены</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Пагинация --}}
            <div class="admin-rooms__pagination">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
@endsection
