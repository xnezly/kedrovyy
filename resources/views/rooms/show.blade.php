@extends('theme')

@section('title', $room->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endpush

@section('content')
    @php
        $reviewsCount = $reviews->count();
        $averageRating = $reviewsCount ? number_format($reviews->avg('rating'), 1) : null;
    @endphp

    <div class="room-show">
        <div class="room-show__container">
            <div class="room-show__wrapper">
                <div class="room-show__card">
                    <div class="room-show__header">
                        <h1 class="room-show__title">{{ $room->name }}</h1>
                        <div class="room-show__header-meta">
                            <span class="room-show__meta-pill">{{ $room->services->count() }} удобств</span>
                            <span class="room-show__meta-pill">{{ $galleryImages->count() }} фото</span>
                        </div>
                    </div>

                    <div class="room-show__gallery">
                        <div class="room-show__carousel-wrapper">
                            <div class="room-show__carousel" data-room-gallery>
                                <div class="room-show__carousel-track">
                                    @foreach($galleryImages as $index => $image)
                                        <div class="room-show__carousel-slide {{ $index === 0 ? 'is-active' : '' }}" data-room-slide="{{ $index }}">
                                            <img
                                                src="{{ $image['url'] }}"
                                                class="room-show__carousel-image"
                                                alt="{{ $image['alt'] }}"
                                            >
                                        </div>
                                    @endforeach
                                </div>

                                @if($galleryImages->count() > 1)
                                    <button
                                        class="room-show__carousel-control room-show__carousel-control--prev"
                                        type="button"
                                        data-room-prev
                                        aria-label="Предыдущее фото"
                                    >
                                        <svg class="room-show__carousel-arrow" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M15 5 8 12l7 7"/>
                                        </svg>
                                    </button>
                                    <button
                                        class="room-show__carousel-control room-show__carousel-control--next"
                                        type="button"
                                        data-room-next
                                        aria-label="Следующее фото"
                                    >
                                        <svg class="room-show__carousel-arrow" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="m9 5 7 7-7 7"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if($galleryImages->count() > 1)
                            <div class="room-show__thumbs" id="roomGalleryThumbs">
                                @foreach($galleryImages as $index => $image)
                                    <button
                                        type="button"
                                        class="room-show__thumb {{ $index === 0 ? 'is-active' : '' }}"
                                        data-room-thumb="{{ $index }}"
                                        aria-label="Показать фото {{ $index + 1 }}"
                                        @if($index === 0) aria-current="true" @endif
                                    >
                                        <img
                                            src="{{ $image['url'] }}"
                                            class="room-show__thumb-image"
                                            alt="{{ $image['alt'] }}"
                                        >
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="room-show__content">
                        <div class="room-show__overview">
                            <div class="room-show__main">
                                <section class="room-show__section room-show__section--description">
                                    <div class="room-show__section-heading">
                                        <h2 class="room-show__section-title">Описание</h2>
                                        <span class="room-show__section-badge">Уютный отдых</span>
                                    </div>
                                    <p class="room-show__text">
                                        {{ $room->description ?? 'Уютный и комфортабельный номер со всеми удобствами. Идеально подходит для отдыха.' }}
                                    </p>
                                </section>

                                <section class="room-show__section room-show__section--amenities">
                                    <div class="room-show__section-heading">
                                        <h2 class="room-show__section-title">Удобства</h2>
                                        <span class="room-show__section-badge">{{ $room->services->count() }} включено</span>
                                    </div>
                                    @if($room->services->isNotEmpty())
                                        <ul class="room-show__amenities-list">
                                            @foreach($room->services as $service)
                                                <li class="room-show__amenity-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#198754"
                                                         class="room-show__amenity-icon" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <span class="room-show__amenity-text">{{ $service->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="room-show__text">Информация об удобствах скоро появится.</p>
                                    @endif
                                </section>
                            </div>

                            <aside class="room-show__booking-card">
                                <span class="room-show__booking-label">Стоимость проживания</span>
                                <p class="room-show__booking-price">{{ $room->formatted_price }}<span>/ночь</span></p>
                                <p class="room-show__booking-note">
                                    Забронируйте номер заранее, чтобы выбрать удобные даты и быстро получить подтверждение.
                                </p>
                                <div class="room-show__booking-features">
                                    <span class="room-show__booking-feature">Быстрое подтверждение</span>
                                    <span class="room-show__booking-feature">Удобные даты</span>
                                    <span class="room-show__booking-feature">Поддержка 24/7</span>
                                </div>

                                <div class="room-show__actions room-show__actions--booking">
                                    @auth
                                        <a href="{{ route('applications.create', $room) }}" class="room-show__button room-show__button--wide" data-page-transition="forward">
                                            Забронировать
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="room-show__button room-show__button--wide">
                                            Войти для бронирования
                                        </a>
                                    @endauth
                                </div>
                            </aside>
                        </div>
                    </div>

                    <section class="room-show__reviews">
                        <div class="reviews">
                            <div class="reviews__intro">
                                <div class="reviews__intro-copy">
                                    <span class="reviews__eyebrow">Отзывы гостей</span>
                                    <h2 class="reviews__headline">Как гостям этот номер</h2>
                                </div>

                                <div class="reviews__summary">
                                    @if($reviewsCount)
                                        <span class="reviews__summary-value">{{ $averageRating }}</span>
                                        <span class="reviews__summary-text">{{ $reviewsCount }} отзывов</span>
                                    @else
                                        <span class="reviews__summary-text">Пока нет отзывов</span>
                                    @endif
                                </div>
                            </div>

                            <div class="reviews__layout">
                                @auth
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
                                @else
                                    <div class="reviews__form">
                                        <h3 class="reviews__title">Войдите, чтобы оставить отзыв</h3>
                                        <p class="reviews__helper">
                                            Оставлять отзывы о номерах могут только авторизованные пользователи.
                                        </p>
                                        <a href="{{ route('login') }}" class="reviews__button">Войти</a>
                                    </div>
                                @endauth

                                <div class="reviews__content">
                                    @if($reviewsCount > 0)
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
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.reviews__rating-star input').forEach((star) => {
            star.addEventListener('change', function () {
                const value = Number.parseInt(this.value, 10);
                const stars = this.closest('.reviews__rating-stars').querySelectorAll('.reviews__rating-star label');

                stars.forEach((starLabel, index) => {
                    const starValue = 5 - index;
                    starLabel.style.color = starValue <= value ? '#ffc107' : '#ddd';
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const gallery = document.querySelector('[data-room-gallery]');
            const track = gallery?.querySelector('.room-show__carousel-track');
            const thumbs = Array.from(document.querySelectorAll('[data-room-thumb]'));
            const slides = Array.from(document.querySelectorAll('[data-room-slide]'));
            const prevButton = document.querySelector('[data-room-prev]');
            const nextButton = document.querySelector('[data-room-next]');

            if (!gallery || !track || slides.length === 0) {
                return;
            }

            let currentIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));

            if (currentIndex < 0) {
                currentIndex = 0;
            }

            const setActiveThumb = (index) => {
                thumbs.forEach((thumb, thumbIndex) => {
                    const isActive = thumbIndex === index;
                    thumb.classList.toggle('is-active', isActive);
                    thumb.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            };

            const setActiveSlide = (index) => {
                currentIndex = (index + slides.length) % slides.length;

                slides.forEach((slide, slideIndex) => {
                    slide.classList.toggle('is-active', slideIndex === currentIndex);
                });

                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                setActiveThumb(currentIndex);
            };

            prevButton?.addEventListener('click', () => {
                setActiveSlide(currentIndex - 1);
            });

            nextButton?.addEventListener('click', () => {
                setActiveSlide(currentIndex + 1);
            });

            thumbs.forEach((thumb, index) => {
                thumb.addEventListener('click', () => {
                    setActiveSlide(index);
                });
            });

            let touchStartX = 0;
            let touchEndX = 0;

            gallery.addEventListener('touchstart', (event) => {
                touchStartX = event.changedTouches[0].clientX;
            }, { passive: true });

            gallery.addEventListener('touchend', (event) => {
                touchEndX = event.changedTouches[0].clientX;

                if (Math.abs(touchStartX - touchEndX) < 40) {
                    return;
                }

                if (touchStartX > touchEndX) {
                    setActiveSlide(currentIndex + 1);
                } else {
                    setActiveSlide(currentIndex - 1);
                }
            }, { passive: true });

            setActiveSlide(currentIndex);
        });
    </script>
@endsection
