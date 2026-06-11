@extends('theme')
@section('title', 'Бронирование')
@section('content')
    <div class="booking">
        <div class="booking__container">
            <div class="booking__wrapper">

                {{-- Заголовок --}}
                <div class="booking__header">
                    <h1 class="booking__title">Бронирование номера</h1>
                    <p class="booking__subtitle">Выберите даты заезда и выезда, чтобы увидеть доступные номера</p>
                </div>

                {{-- Форма выбора дат --}}
                <div class="booking__form-card">
                    <form id="availabilityForm" class="booking__form" action="{{ route('booking') }}" method="GET">
                        <div class="booking__form-row">
                            <div class="booking__form-group">
                                <label class="booking__form-label" for="check_in">Дата заезда</label>
                                <input type="date"
                                       class="booking__form-input"
                                       id="check_in"
                                       name="check_in"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ $checkIn->format('Y-m-d') }}"
                                       required>
                            </div>
                            <div class="booking__form-group">
                                <label class="booking__form-label" for="check_out">Дата выезда</label>
                                <input type="date"
                                       class="booking__form-input"
                                       id="check_out"
                                       name="check_out"
                                       min="{{ $checkIn->copy()->addDay()->format('Y-m-d') }}"
                                       value="{{ $checkOut->format('Y-m-d') }}"
                                       required>
                            </div>
                            <div class="booking__form-group booking__form-group--button">
                                <button type="submit" class="booking__form-submit">
                                    Проверить доступность
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Результаты --}}
                <div id="results" class="booking__results">
                    <div class="booking__results-header">
                        <h3 class="booking__results-title">
                            Доступные номера с {{ $checkIn->format('d.m.Y') }} по {{ $checkOut->format('d.m.Y') }} ({{ $rooms->count() }})
                        </h3>
                        <span class="booking__results-badge">
                            {{ $nights }} ночей
                        </span>
                    </div>

                    <div class="card-container">
                        @forelse($rooms as $room)
                            @include('parts.room')
                        @empty
                            {{-- Сообщение если нет доступных номеров --}}
                            <div id="noRooms" class="booking__no-rooms">
                                <div class="booking__no-rooms-icon">📅</div>
                                <h3 class="booking__no-rooms-title">К сожалению, на выбранные даты нет свободных
                                    номеров</h3>
                                <p class="booking__no-rooms-text">Попробуйте выбрать другие даты или свяжитесь с
                                    нами</p>
                                <a href="{{ route('contacts') }}" class="booking__btn booking__btn--outline">
                                    Контакты
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script defer src="{{ asset('js/booking-availability.js') }}"></script>
@endpush
