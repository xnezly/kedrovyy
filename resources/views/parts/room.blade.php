<div class="card">
    <div class="card__img">
        <img src="{{ $room->image_url ?? '/img/photo.webp' }}" class="js-skeleton-image" alt="{{ $room->name ?? 'Номер' }}">

        @if($room->services_count)
            <span class="card__badge">
                {{ $room->services_count }} удобств
            </span>
        @endif
    </div>

    <div class="card__wrapper">
        <div class="card__content">
            <h5 class="card__title">{{ $room->name ?? 'Название номера' }}</h5>

            <p class="card__description">
                {{ $room->description ?? 'Уютный номер со всеми удобствами' }}
            </p>

            @if($room->services_count)
                <div class="card__amenities-list">
                    @foreach($room->services->take(3) as $service)
                        <span class="card__amenity">
                            {{ $service->name }}
                        </span>
                    @endforeach
                    @if($room->services_count > 3)
                        <span class="card__amenity card__amenity--more">
                            +{{ $room->services_count - 3 }} еще
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <div class="card__footer">
            <p class="card__price">{{ $room->formatted_price }}<span>/ночь</span></p>

            <a
                href="{{ route('rooms.show', $room) }}"
                class="btn btn--outline-pill card__button"
                aria-label="Перейти к номеру {{ $room->name ?? 'Подробнее о номере' }}"
            >
                Подробнее
            </a>
        </div>
    </div>
</div>
