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
                    <form id="availabilityForm" class="booking__form">
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
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
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
                            <div id="noRooms" class="booking__no-rooms" style="display: none;">
                                <div class="booking__no-rooms-icon">📅</div>
                                <h3 class="booking__no-rooms-title">К сожалению, на выбранные даты нет свободных
                                    номеров</h3>
                                <p class="booking__no-rooms-text">Попробуйте выбрать другие даты или свяжитесь с
                                    нами</p>
                                <a href="/contacts" class="booking__btn booking__btn--outline">
                                    Контакты
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--    <script>--}}
    {{--        document.addEventListener('DOMContentLoaded', function () {--}}
    {{--            const form = document.getElementById('availabilityForm');--}}
    {{--            const resultsDiv = document.getElementById('results');--}}
    {{--            const noRoomsDiv = document.getElementById('noRooms');--}}
    {{--            const roomsContainer = document.getElementById('roomsContainer');--}}
    {{--            const checkInInput = document.getElementById('check_in');--}}
    {{--            const checkOutInput = document.getElementById('check_out');--}}

    {{--            // Обновление минимальной даты выезда при изменении заезда--}}
    {{--            checkInInput.addEventListener('change', function () {--}}
    {{--                const checkIn = new Date(this.value);--}}
    {{--                checkIn.setDate(checkIn.getDate() + 1);--}}
    {{--                checkOutInput.min = checkIn.toISOString().split('T')[0];--}}

    {{--                if (checkOutInput.value && checkOutInput.value <= this.value) {--}}
    {{--                    checkOutInput.value = checkIn.toISOString().split('T')[0];--}}
    {{--                }--}}
    {{--            });--}}

    {{--            // Отправка формы--}}
    {{--            form.addEventListener('submit', async function (e) {--}}
    {{--                e.preventDefault();--}}

    {{--                const formData = new FormData(this);--}}
    {{--                const checkIn = formData.get('check_in');--}}
    {{--                const checkOut = formData.get('check_out');--}}

    {{--                // Показываем загрузку--}}
    {{--                roomsContainer.innerHTML = `--}}
    {{--                    <div class="booking__spinner-wrapper">--}}
    {{--                        <div class="booking__spinner"></div>--}}
    {{--                        <p class="booking__spinner-text">Проверяем доступность номеров...</p>--}}
    {{--                    </div>--}}
    {{--                `;--}}
    {{--                resultsDiv.style.display = 'block';--}}
    {{--                noRoomsDiv.style.display = 'none';--}}

    {{--                try {--}}
    {{--                    const response = await fetch('{{ route("booking.check") }}', {--}}
    {{--                        method: 'POST',--}}
    {{--                        headers: {--}}
    {{--                            'Content-Type': 'application/json',--}}
    {{--                            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
    {{--                        },--}}
    {{--                        body: JSON.stringify({--}}
    {{--                            check_in: checkIn,--}}
    {{--                            check_out: checkOut--}}
    {{--                        })--}}
    {{--                    });--}}

    {{--                    const data = await response.json();--}}

    {{--                    // Обновляем заголовок--}}
    {{--                    document.getElementById('resultCheckIn').textContent = data.check_in;--}}
    {{--                    document.getElementById('resultCheckOut').textContent = data.check_out;--}}
    {{--                    document.getElementById('resultNights').textContent = data.nights;--}}

    {{--                    // Показываем номера--}}
    {{--                    if (data.available_rooms.length > 0) {--}}
    {{--                        roomsContainer.innerHTML = '';--}}
    {{--                        data.available_rooms.forEach(item => {--}}
    {{--                            roomsContainer.innerHTML += createRoomCard(item, checkIn, checkOut);--}}
    {{--                        });--}}
    {{--                        resultsDiv.style.display = 'block';--}}
    {{--                        noRoomsDiv.style.display = 'none';--}}
    {{--                    } else {--}}
    {{--                        resultsDiv.style.display = 'none';--}}
    {{--                        noRoomsDiv.style.display = 'block';--}}
    {{--                    }--}}

    {{--                } catch (error) {--}}
    {{--                    console.error('Error:', error);--}}
    {{--                    roomsContainer.innerHTML = `--}}
    {{--                        <div class="booking__error">--}}
    {{--                            <span class="booking__error-icon">⚠️</span>--}}
    {{--                            Произошла ошибка при проверке доступности. Попробуйте позже.--}}
    {{--                        </div>--}}
    {{--                    `;--}}
    {{--                }--}}
    {{--            });--}}

    {{--            // Создание карточки номера--}}
    {{--            function createRoomCard(item, checkIn, checkOut) {--}}
    {{--                const room = item.room;--}}
    {{--                const amenities = room.amenities_array || [];--}}

    {{--                return `--}}
    {{--                    <div class="card-container">--}}
    {{--        @foreach($rooms as $room)--}}
    {{--                @include('parts.room', ['room'=>$room])--}}
    {{--                @endforeach--}}
    {{--                </div>--}}
    {{--`;--}}
    {{--            }--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection
