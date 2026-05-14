@extends('theme')
@section('title', $room->name)
@section('content')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <div class="room-show">
        <div class="room-show__container">
            <div class="room-show__wrapper">
                <div class="room-show__card">
                    <div class="room-show__header">
                        <h1 class="room-show__title">{{ $room->name }}</h1>
                    </div>

{{--                    <div class="room-show__carousel-wrapper">--}}
{{--                        <div id="roomCarousel" class="room-show__carousel carousel slide" data-bs-ride="carousel">--}}
{{--                            <div class="room-show__carousel-indicators carousel-indicators">--}}
{{--                                <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="0" class="active"--}}
{{--                                        aria-current="true" aria-label="Slide 1"></button>--}}
{{--                                <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="1"--}}
{{--                                        aria-label="Slide 2"></button>--}}
{{--                                <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="2"--}}
{{--                                        aria-label="Slide 3"></button>--}}
{{--                            </div>--}}
{{--                            <div class="room-show__carousel-inner carousel-inner">--}}
{{--                                <div class="room-show__carousel-item carousel-item active">--}}
{{--                                    <img src="{{ asset('img/photo.jpg') }}"--}}
{{--                                         class="room-show__carousel-image"--}}
{{--                                         alt="{{ $room->name ?? 'Номер' }}">--}}
{{--                                </div>--}}
{{--                                @if($room->images->isNotEmpty())--}}
{{--                                    @foreach($room->images as $image)--}}
{{--                                        <div class="room-show__carousel-item carousel-item">--}}
{{--                                            <img--}}
{{--                                                src="{{ $image->url }}"--}}
{{--                                                class="room-show__carousel-image"--}}
{{--                                                alt="{{ $room->name }}"--}}
{{--                                            >--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <button--}}
{{--                                class="room-show__carousel-control room-show__carousel-control--prev carousel-control-prev"--}}
{{--                                type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">--}}
{{--                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
{{--                                <span class="visually-hidden">Previous</span>--}}
{{--                            </button>--}}
{{--                            <button--}}
{{--                                class="room-show__carousel-control room-show__carousel-control--next carousel-control-next"--}}
{{--                                type="button" data-bs-target="#roomCarousel" data-bs-slide="next">--}}
{{--                                <span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
{{--                                <span class="visually-hidden">Next</span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="px-4 pb-3">
                        <div id="roomCarousel" class="carousel slide rounded-3 overflow-hidden w-100" data-bs-ride="carousel">
{{--                            <div class="carousel-indicators">--}}
{{--                                <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>--}}
{{--                                <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>--}}
{{--                                <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>--}}
{{--                            </div>--}}
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ $room->image ?? asset('img/photo.jpg') }}"
                                         class="d-block w-100"
                                         style="height: 400px; object-fit: cover;"
                                         alt="{{ $room->name ?? 'Номер' }}">
                                </div>
{{--                                @if($room->images && count($room->images) > 0)--}}
{{--                                    @foreach($room->images as $index => $image)--}}
{{--                                        <div class="carousel-item">--}}
{{--                                            <img src="{{ $image }}"--}}
{{--                                                 class="d-block w-100"--}}
{{--                                                 style="height: 400px; object-fit: cover;"--}}
{{--                                                 alt="{{ $room->name }} {{ $index + 1 }}">--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
                                <div class="carousel-item">
                                    <img src="{{ asset('img/vid1.png') }}" class="d-block w-100" alt="v1">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('img/vid2.png') }}" class="d-block w-100" alt="v1">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('img/vid3.png') }}" class="d-block w-100" alt="v1">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="room-show__content">
                        <div class="room-show__section room-show__section--description">
                            <h2 class="room-show__section-title">Описание</h2>
                            <p class="room-show__text">{{ $room->description ?? 'Уютный и комфортабельный номер со всеми удобствами. Идеально подходит для отдыха.' }}</p>
                        </div>

                        <div class="room-show__section room-show__section--price">
                            <p class="room-show__price">
                                Цена: <span class="room-show__price-value">{{ $room->formatted_price }}/ночь</span>
                            </p>
                        </div>

                        <div class="room-show__section room-show__section--amenities">
                            <h2 class="room-show__section-title">Удобства:</h2>
                            <ul class="room-show__amenities-list">
                                @foreach($room->services as $service)
                                    <li class="room-show__amenity-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28a745"
                                             class="room-show__amenity-icon" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </svg>
                                        <span class="room-show__amenity-text">{{ $service->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="room-show__actions">
                            @auth
                                <a href="{{ route('applications.create', $room) }}" class="room-show__button">
                                    Забронировать
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="room-show__button">
                                    Войти для бронирования
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="reviews__container">

    <div class="reviews">
        <form action="{{ route('rooms.comment', $room) }}" method="post" class="reviews__form">
            @csrf

            <h3 class="reviews__title">Оставить отзыв</h3>

            <div class="reviews__rating">
                <span class="reviews__rating-label">Ваша оценка:</span>
                <div class="reviews__rating-stars">
                    <div class="reviews__rating-star">
                        <input type="radio" name="rating" id="star5" value="5" required>
                        <label for="star5">★</label>
                    </div>
                    <div class="reviews__rating-star">
                        <input type="radio" name="rating" id="star4" value="4">
                        <label for="star4">★</label>
                    </div>
                    <div class="reviews__rating-star">
                        <input type="radio" name="rating" id="star3" value="3">
                        <label for="star3">★</label>
                    </div>
                    <div class="reviews__rating-star">
                        <input type="radio" name="rating" id="star2" value="2">
                        <label for="star2">★</label>
                    </div>
                    <div class="reviews__rating-star">
                        <input type="radio" name="rating" id="star1" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>
            </div>

            <textarea
                name="comment"
                class="reviews__textarea"
                placeholder="Напишите ваш отзыв..."
                required
            ></textarea>

            <button type="submit" class="reviews__button">Оставить отзыв</button>
        </form>

        @if($reviews->count() > 0)
            <div class="reviews__list">
                @foreach($reviews as $review)
                    <div class="reviews__item">
                        <div class="reviews__header">
                            <h3 class="reviews__author">{{ $review->user->name }}</h3>
                            <div class="reviews__rating-value">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <span class="star">★</span>
                                @endfor
                                @for($i = $review->rating; $i < 5; $i++)
                                    <span class="star" style="color: #ddd;">★</span>
                                @endfor
                                <span>({{ $review->rating }}/5)</span>
                            </div>
                        </div>
                        <p class="reviews__text">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="reviews__empty">
                Пока нет отзывов. Будьте первым!
            </div>
        @endif
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.reviews__rating-star input').forEach(star => {
            star.addEventListener('change', function() {
                const value = parseInt(this.value);
                const stars = this.closest('.reviews__rating-stars').querySelectorAll('.reviews__rating-star label');

                stars.forEach((starLabel, index) => {
                    const starValue = 5 - index;
                    if (starValue <= value) {
                        starLabel.style.color = '#ffc107';
                    } else {
                        starLabel.style.color = '#ddd';
                    }
                });
            });
        });
    </script>
@endsection
