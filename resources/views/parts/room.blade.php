<div class="card">
    <div class="card__img">
        <img src="{{ asset('img/photo.jpg') }}" alt="{{ $room->name ?? 'Номер' }}">

        {{-- Бейдж (опционально) --}}
        @if($room->services_count)
            <span
                class="card__amenities">
                {{ $room->services_count }} удобств
            </span>
        @endif
    </div>

    <div class="card__wrapper">
        <h5 class="card__title">{{ $room->name ?? 'Название номера' }}</h5>

        <p class="card__description">
            {{ $room->description ?? 'Уютный номер со всеми удобствами' }}
        </p>

        {{-- Удобства (иконки) --}}
        @if($room->services_count)
            <div class="card__amenities-info">
                @foreach($room->services->take(3) as $service)
                    <span class="card__amenities-info">
                        {{ $service->name }}
                    </span>
                @endforeach
                @if($room->services_count > 3)
                    <span class="card__amenities-info">
                        +{{ $room->services_count - 3 }} ещё
                    </span>
                @endif
            </div>
        @endif

        <p class="card__price text-success fw-bold fs-5 mb-3">{{ $room->formatted_price }}<span
                class="text-muted small fw-normal">/ночь</span></p>

        <a href="{{ route('rooms.show', $room) }}" class="btn btn--outline-pill">Подробнее</a>
    </div>
</div>
