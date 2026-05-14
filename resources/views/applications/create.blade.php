@extends('theme')
@section('content')
    <div class="booking-page">
        <div class="booking-page__container">
            <div class="booking-card">

                {{-- Заголовок --}}
                <div class="booking-card__header">
                    <h1 class="booking-card__title">Бронирование номера</h1>
                    <h2 class="booking-card__room-name">{{ $room->name ?? 'Стандартный номер' }}</h2>
                    <p class="booking-card__price">
                        Цена: <span class="booking-card__price-value">{{ number_format($room->price ?? 2000, 0, '.', ' ') }} руб/ночь</span>
                    </p>
                </div>

                {{-- Ошибки валидации --}}
                @if($errors->any())
                    <div class="booking-alert booking-alert--error">
                        <svg class="booking-alert__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        <div class="booking-alert__content">
                            <h6 class="booking-alert__title">Ошибка в форме:</h6>
                            <ul class="booking-alert__list">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Форма бронирования --}}
                <form action="{{ route('applications.store', $room) }}" method="POST" class="booking-form">
                    @csrf

                    {{-- Имя и возраст --}}
                    <div class="booking-form__row">
                        <div class="booking-form__col">
                            <div class="booking-form__field">
                                <input type="text"
                                       class="booking-form__input @error('name') booking-form__input--invalid @enderror"
                                       id="name"
                                       name="name"
                                       placeholder=" "
                                       value="{{ old('name', auth()->user()->name ?? '') }}">
                                <label class="booking-form__label" for="name">Ваше имя *</label>
                                @error('name')
                                <span class="booking-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="booking-form__col">
                            <div class="booking-form__field">
                                <input type="number"
                                       class="booking-form__input @error('age') booking-form__input--invalid @enderror"
                                       id="age"
                                       name="age"
                                       placeholder=" "
                                       value="{{ old('age') }}">
                                <label class="booking-form__label" for="age">Возраст *</label>
                                @error('age')
                                <span class="booking-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Телефон --}}
                    <div class="booking-form__field">
                        <input type="tel"
                               class="booking-form__input @error('number') booking-form__input--invalid @enderror"
                               id="phone"
                               name="number"
                               placeholder=" "
                               maxlength="18"
                               value="{{ old('number') }}">
                        <label class="booking-form__label" for="phone">Номер телефона *</label>
                        @error('number')
                        <span class="booking-form__error">{{ $message }}</span>
                        @enderror
                        <small class="booking-form__hint">Пример: +7 (999) 123-45-67</small>
                    </div>

                    {{-- Количество гостей и ночей --}}
                    <div class="booking-form__row">
                        <div class="booking-form__col">
                            <div class="booking-form__field">
                                <input type="number"
                                       class="booking-form__input @error('number of guests') booking-form__input--invalid @enderror"
                                       id="number of guests"
                                       name="number of guests"
                                       placeholder=" "
                                       min="1"
                                       max="20"
                                       value="{{ old('number of guests', 1) }}">
                                <label class="booking-form__label" for="number of guests">Количество гостей *</label>
                                @error('number of guests')
                                <span class="booking-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="booking-form__col">
                            <div class="booking-form__field">
                                <input type="number"
                                       class="booking-form__input booking-form__input--readonly"
                                       id="nights"
                                       disabled
                                       value="0">
                                <label class="booking-form__label" for="nights">Ночей</label>
                            </div>
                        </div>
                    </div>

                    {{-- Даты заезда и выезда --}}
                    <div class="booking-form__row">
                        <div class="booking-form__col">
                            <div class="booking-form__field">
                                <input type="date"
                                       class="booking-form__input @error('check_in') booking-form__input--invalid @enderror"
                                       id="check_in"
                                       name="check_in"
                                       value="{{ old('check_in') }}"
                                       min="{{ date('Y-m-d') }}">
                                <label class="booking-form__label" for="check_in">Дата заезда *</label>
                                @error('check_in')
                                <span class="booking-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="booking-form__col">
                            <div class="booking-form__field">
                                <input type="date"
                                       class="booking-form__input @error('check_out') booking-form__input--invalid @enderror"
                                       id="check_out"
                                       name="check_out"
                                       value="{{ old('check_out') }}">
                                <label class="booking-form__label" for="check_out">Дата выезда *</label>
                                @error('check_out')
                                <span class="booking-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Комментарий --}}
                    <div class="booking-form__field">
                        <textarea class="booking-form__textarea booking-form__textarea--large @error('comment') booking-form__input--invalid @enderror"
                                  id="comment"
                                  name="comment"
                                  placeholder=" ">{{ old('comment') }}</textarea>
                        <label class="booking-form__label booking-form__label--textarea" for="comment">Комментарий к бронированию</label>
                        @error('comment')
                        <span class="booking-form__error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Кнопка отправки --}}
                    <button type="submit" class="booking-form__submit">
                        Отправить заявку на бронирование
                    </button>

                    {{-- Ссылка назад --}}
                    <div class="booking-form__footer">
                        <a href="{{ route('rooms.show', $room) }}" class="booking-form__back-link">
                            ← Вернуться к описанию номера
                        </a>
                    </div>
                </form>

                {{-- Дополнительные услуги --}}
                <div class="booking-services">
                    <h3 class="booking-services__title">
                        <i class="bi bi-briefcase"></i>Дополнительные услуги
                    </h3>

                    @if($services->count() > 0)
                        <div class="booking-services__grid">
                            @foreach($services as $service)
                                <div class="booking-services__card">
                                    <div class="booking-services__card-body">
                                        <label class="booking-services__label" for="service_{{ $service->id }}">
                                            <div class="booking-services__checkbox-wrapper">
                                                <input class="booking-services__checkbox service-checkbox"
                                                       type="checkbox"
                                                       name="services[]"
                                                       value="{{ $service->id }}"
                                                       id="service_{{ $service->id }}"
                                                       onchange="toggleServiceQuantity({{ $service->id }}); calculateServicesTotal()">

                                                <div class="booking-services__card-content">
                                                    <div class="booking-services__card-header">
                                                        <div class="booking-services__card-info">
                                                            <strong class="booking-services__name">{{ $service->name }}</strong>
                                                            @if($service->description)
                                                                <span class="booking-services__desc">{{ Str::limit($service->description, 40) }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="booking-services__price">
                                                            {{ number_format($service->price, 0, '.', ' ') }} ₽
                                                        </div>
                                                    </div>

                                                    {{-- Поле количества --}}
                                                    <div id="quantity_{{ $service->id }}" class="booking-services__quantity" style="display: none;">
                                                        <label class="booking-services__quantity-label">Количество:</label>
                                                        <input type="number"
                                                               name="service_quantity[{{ $service->id }}]"
                                                               class="booking-services__quantity-input"
                                                               value="1"
                                                               min="1"
                                                               max="10"
                                                               onchange="calculateServicesTotal()">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Итого за услуги --}}
                        <div class="booking-services__total" id="servicesTotalBlock" style="display: none;">
                            <div class="booking-services__total-inner">
                                <span class="booking-services__total-label">Итого за услуги:</span>
                                <span class="booking-services__total-value" id="servicesTotal">0 ₽</span>
                            </div>
                        </div>
                    @else
                        <p class="booking-services__empty">Дополнительные услуги временно недоступны</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script src="/js/phone-mask.js"></script>
    <script>
        // Показ/скрытие поля количества
        function toggleServiceQuantity(serviceId) {
            const checkbox = document.getElementById('service_' + serviceId);
            const quantityBlock = document.getElementById('quantity_' + serviceId);
            quantityBlock.style.display = checkbox.checked ? 'block' : 'none';
        }

        // Подсчёт общей стоимости
        function calculateServicesTotal() {
            let total = 0;

            document.querySelectorAll('.service-checkbox:checked').forEach(checkbox => {
                const serviceId = checkbox.value;
                const priceText = checkbox.closest('.booking-services__card-body').querySelector('.booking-services__price').textContent;
                const price = parseInt(priceText.replace(/\D/g, ''));
                const qtyInput = document.querySelector(`input[name="service_quantity[${serviceId}]"]`);
                const quantity = parseInt(qtyInput?.value || 1);
                total += price * quantity;
            });

            const totalBlock = document.getElementById('servicesTotalBlock');
            const totalText = document.getElementById('servicesTotal');

            if (total > 0) {
                totalText.textContent = new Intl.NumberFormat('ru-RU').format(total) + ' ₽';
                totalBlock.style.display = 'block';
            } else {
                totalBlock.style.display = 'none';
            }
        }

        // Подсветка выбранной карточки
        document.querySelectorAll('.service-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const card = this.closest('.booking-services__card');
                if (this.checked) {
                    card.classList.add('booking-services__card--selected');
                } else {
                    card.classList.remove('booking-services__card--selected');
                }
            });
        });

        // Автоматический подсчёт ночей
        document.getElementById('check_in')?.addEventListener('change', calculateNights);
        document.getElementById('check_out')?.addEventListener('change', calculateNights);

        function calculateNights() {
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            const nightsInput = document.getElementById('nights');

            if (checkIn && checkOut) {
                const start = new Date(checkIn);
                const end = new Date(checkOut);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (end > start) {
                    nightsInput.value = diffDays;
                } else {
                    nightsInput.value = 0;
                }
            } else {
                nightsInput.value = 0;
            }
        }
    </script>
@endsection
