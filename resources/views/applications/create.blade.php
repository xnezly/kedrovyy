@extends('theme')

@section('title', 'Бронирование номера')

@section('content')
    @php
        $roomImage = $room->image_url ?: asset('img/photo.jpg');
        $roomPrice = (int) ($room->price ?? 2000);
        $selectedServices = collect(old('services', []))->map(fn ($id) => (int) $id)->all();
        $contactPhone = old('number', \App\Models\Application::formatPhone(auth()->user()->phone ?? null));
        $contactAge = old('age', auth()->user()->age ?? '');
    @endphp

    <div class="booking-page">
        <div class="booking-page__container">
            @if($errors->any())
                <div class="booking-alert booking-alert--error">
                    <svg class="booking-alert__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div class="booking-alert__content">
                        <h2 class="booking-alert__title">Проверьте заполнение формы</h2>
                        <ul class="booking-alert__list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <section class="booking-hero">
                <div class="booking-hero__media">
                    <img src="{{ $roomImage }}" alt="{{ $room->name }}" class="booking-hero__image">
                    <div class="booking-hero__badge">
                        <span>Уютный отдых в гостевом доме «Кедровый»</span>
                    </div>
                </div>

                <div class="booking-hero__content">
                    <h1 class="booking-hero__title">Бронирование номера</h1>
                    <h2 class="booking-hero__room-name">{{ $room->name ?? 'Стандартный номер' }}</h2>
                    <p class="booking-hero__description">
                        {{ $room->description ?? 'Выберите даты, укажите детали поездки и отправьте заявку на бронирование. Мы свяжемся с вами для подтверждения.' }}
                    </p>

                    <div class="booking-hero__meta">
                        <div class="booking-hero__meta-item">
                            <i class="bi bi-cash-coin" aria-hidden="true"></i>
                            <div>
                                <span class="booking-hero__meta-label">Стоимость</span>
                                <strong class="booking-hero__meta-value">{{ number_format($roomPrice, 0, '.', ' ') }} ₽ за ночь</strong>
                            </div>
                        </div>

                        <div class="booking-hero__meta-item">
                            <i class="bi bi-shield-check" aria-hidden="true"></i>
                            <div>
                                <span class="booking-hero__meta-label">После отправки</span>
                                <strong class="booking-hero__meta-value">Мы свяжемся с вами для подтверждения заявки</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <form action="{{ route('applications.store', $room) }}" method="POST" class="booking-shell" id="bookingForm">
                @csrf

                <div class="booking-main">
                    <section class="booking-block">
                        <div class="booking-block__head">
                            <span class="booking-block__eyebrow">Контактные данные</span>
                            <h2 class="booking-block__title">Расскажите, кто будет бронировать</h2>
                            <p class="booking-block__subtitle">Оставьте основную информацию, чтобы мы могли быстро связаться с вами.</p>
                        </div>

                        <div class="booking-form">
                            <div class="booking-form__row">
                                <div class="booking-form__col">
                                    <div class="booking-form__field">
                                        <input type="text"
                                               class="booking-form__input @error('name') booking-form__input--invalid @enderror"
                                               id="name"
                                               name="name"
                                               placeholder=" "
                                               required
                                               value="{{ old('name', auth()->user()->name ?? '') }}">
                                        <label class="booking-form__label" for="name">Ваше имя</label>
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
                                               min="0"
                                               max="120"
                                               inputmode="numeric"
                                               value="{{ $contactAge }}">
                                        <label class="booking-form__label" for="age">Возраст</label>
                                        @error('age')
                                        <span class="booking-form__error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="booking-form__field">
                                <input type="tel"
                                       class="booking-form__input @error('number') booking-form__input--invalid @enderror"
                                       id="phone"
                                       name="number"
                                       placeholder=" "
                                       required
                                       inputmode="tel"
                                       autocomplete="tel"
                                       maxlength="18"
                                       data-phone-mask
                                       value="{{ $contactPhone }}">
                                <label class="booking-form__label" for="phone">Номер телефона</label>
                                @error('number')
                                <span class="booking-form__error">{{ $message }}</span>
                                @enderror
                                <small class="booking-form__hint">Пример: +7 (999) 123-45-67</small>
                            </div>
                        </div>
                    </section>

                    <section class="booking-block">
                        <div class="booking-block__head">
                            <span class="booking-block__eyebrow">Детали поездки</span>
                            <h2 class="booking-block__title">Выберите даты и параметры проживания</h2>
                            <p class="booking-block__subtitle">Укажите, когда планируете приехать и сколько гостей будет в номере.</p>
                        </div>

                        <div class="booking-form">
                            <div class="booking-form__row">
                                <div class="booking-form__col">
                                    <div class="booking-form__field">
                                        <input type="number"
                                               class="booking-form__input @error('number_of_guests') booking-form__input--invalid @enderror"
                                               id="number_of_guests"
                                               name="number_of_guests"
                                               placeholder=" "
                                               min="1"
                                               max="20"
                                               value="{{ old('number_of_guests', 1) }}">
                                        <label class="booking-form__label" for="number_of_guests">Количество гостей *</label>
                                        @error('number_of_guests')
                                        <span class="booking-form__error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="booking-form__col">
                                    <div class="booking-form__field">
                                        <input type="number"
                                               class="booking-form__input booking-form__input--readonly"
                                               id="nights"
                                               value="0"
                                               readonly>
                                        <label class="booking-form__label" for="nights">Ночей</label>
                                    </div>
                                </div>
                            </div>

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
                        </div>
                    </section>

                    <section class="booking-block">
                        <div class="booking-block__head">
                            <span class="booking-block__eyebrow">Пожелания</span>
                            <h2 class="booking-block__title">Дополнительная информация к заявке</h2>
                            <p class="booking-block__subtitle booking-block__subtitle--centered">Если есть важные детали, напишите их заранее.</p>
                        </div>

                        <div class="booking-form">
                            <div class="booking-form__field booking-form__field--no-margin">
                                <textarea class="booking-form__textarea booking-form__textarea--large @error('comment') booking-form__input--invalid @enderror"
                                          id="comment"
                                          name="comment"
                                          placeholder=" ">{{ old('comment') }}</textarea>
                                <label class="booking-form__label booking-form__label--textarea" for="comment">Комментарий к бронированию</label>
                                @error('comment')
                                <span class="booking-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section class="booking-block booking-block--services">
                        <div class="booking-block__head">
                            <span class="booking-block__eyebrow">Дополнительно</span>
                            <h2 class="booking-block__title">Услуги, которые можно добавить к отдыху</h2>
                            <p class="booking-block__subtitle booking-block__subtitle--centered">Выберите только то, что действительно понадобится во время проживания.</p>
                        </div>

                        @if($services->count() > 0)
                            <div class="booking-services__grid">
                                @foreach($services as $service)
                                    @php $isSelected = in_array($service->id, $selectedServices, true); @endphp
                                    <label class="booking-services__card {{ $isSelected ? 'booking-services__card--selected' : '' }}" for="service_{{ $service->id }}">
                                        <input class="booking-services__checkbox service-checkbox"
                                               type="checkbox"
                                               name="services[]"
                                               value="{{ $service->id }}"
                                               data-price="{{ $service->price }}"
                                               data-name="{{ $service->name }}"
                                               id="service_{{ $service->id }}"
                                               {{ $isSelected ? 'checked' : '' }}>

                                        <span class="booking-services__check">
                                            <i class="bi bi-check2" aria-hidden="true"></i>
                                        </span>

                                        <span class="booking-services__card-body">
                                            <span class="booking-services__card-header">
                                                <span class="booking-services__card-info">
                                                    <strong class="booking-services__name">{{ $service->name }}</strong>
                                                    @if($service->description)
                                                        <span class="booking-services__desc">{{ Str::limit($service->description, 80) }}</span>
                                                    @endif
                                                </span>
                                                <span class="booking-services__price">{{ number_format($service->price, 0, '.', ' ') }} ₽</span>
                                            </span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p class="booking-services__empty">Дополнительные услуги временно недоступны.</p>
                        @endif
                    </section>
                </div>

                <aside class="booking-sidebar">
                    <div class="booking-summary">
                        <div class="booking-summary__head">
                            <span class="booking-summary__eyebrow">Ваше бронирование</span>
                            <h2 class="booking-summary__title">Краткая сводка по заявке</h2>
                        </div>

                        <div class="booking-summary__price-block">
                            <span class="booking-summary__price-label">Стоимость номера</span>
                            <strong class="booking-summary__price-value">{{ number_format($roomPrice, 0, '.', ' ') }} ₽</strong>
                            <span class="booking-summary__price-note">за одну ночь проживания</span>
                        </div>

                        <div class="booking-summary__list">
                            <div class="booking-summary__item">
                                <span class="booking-summary__item-label">Номер</span>
                                <strong class="booking-summary__item-value">{{ $room->name }}</strong>
                            </div>

                            <div class="booking-summary__item">
                                <span class="booking-summary__item-label">Гостей</span>
                                <strong class="booking-summary__item-value" id="bookingSummaryGuests">1 гость</strong>
                            </div>

                            <div class="booking-summary__item">
                                <span class="booking-summary__item-label">Период</span>
                                <strong class="booking-summary__item-value" id="bookingSummaryDates">Выберите даты</strong>
                            </div>

                            <div class="booking-summary__item">
                                <span class="booking-summary__item-label">Ночей</span>
                                <strong class="booking-summary__item-value" id="bookingSummaryNights">0</strong>
                            </div>
                        </div>

                        <div class="booking-summary__services" id="bookingSummaryServices" hidden>
                            <span class="booking-summary__services-label">&#1042;&#1099;&#1073;&#1088;&#1072;&#1085;&#1085;&#1099;&#1077; &#1091;&#1089;&#1083;&#1091;&#1075;&#1080;</span>
                            <div class="booking-summary__services-list" id="bookingSummaryServicesList"></div>
                        </div>

                        <div class="booking-summary__totals">
                            <div class="booking-summary__total-row">
                                <span>Проживание</span>
                                <strong id="bookingRoomTotal">0 ₽</strong>
                            </div>

                            <div class="booking-summary__total-row" id="bookingServicesRow" hidden>
                                <span>Услуги</span>
                                <strong id="bookingServicesTotal">0 ₽</strong>
                            </div>

                            <div class="booking-summary__total-row booking-summary__total-row--grand">
                                <span>Ориентировочная сумма</span>
                                <strong id="bookingGrandTotal">0 ₽</strong>
                            </div>
                        </div>

                        <p class="booking-summary__note">
                            После отправки заявки мы проверим доступность номера на выбранные даты и подтвердим бронирование.
                        </p>

                        <button type="submit" class="booking-summary__submit">
                            Отправить заявку на бронирование
                        </button>

                        <a href="{{ route('rooms.show', $room) }}" class="booking-summary__back-link" data-page-transition="back">
                            <i class="bi bi-arrow-left" aria-hidden="true"></i>
                            <span>Вернуться к описанию номера</span>
                        </a>
                    </div>
                </aside>
            </form>

            <div class="booking-mobile-bar">
                <div class="booking-mobile-bar__total">
                    <span class="booking-mobile-bar__label">Итого</span>
                    <strong class="booking-mobile-bar__value" id="bookingGrandTotalMobile">0 ₽</strong>
                </div>

                <button type="submit" form="bookingForm" class="booking-mobile-bar__button">
                    Забронировать
                </button>
            </div>
        </div>
    </div>

    <script src="/js/phone-mask.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roomPrice = {{ $roomPrice }};
            const ageInput = document.getElementById('age');
            const guestsInput = document.getElementById('number_of_guests');
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            const nightsInput = document.getElementById('nights');
            const serviceCheckboxes = document.querySelectorAll('.service-checkbox');

            const summaryGuests = document.getElementById('bookingSummaryGuests');
            const summaryDates = document.getElementById('bookingSummaryDates');
            const summaryNights = document.getElementById('bookingSummaryNights');
            const summaryServices = document.getElementById('bookingSummaryServices');
            const summaryServicesList = document.getElementById('bookingSummaryServicesList');
            const roomTotal = document.getElementById('bookingRoomTotal');
            const servicesRow = document.getElementById('bookingServicesRow');
            const servicesTotal = document.getElementById('bookingServicesTotal');
            const grandTotal = document.getElementById('bookingGrandTotal');
            const grandTotalMobile = document.getElementById('bookingGrandTotalMobile');

            function formatMoney(value) {
                return new Intl.NumberFormat('ru-RU').format(value) + ' ₽';
            }

            function formatDate(value) {
                if (!value) {
                    return '';
                }

                const [year, month, day] = value.split('-');
                return [day, month, year].join('.');
            }

            function calculateNights() {
                const checkIn = checkInInput?.value;
                const checkOut = checkOutInput?.value;

                if (checkInInput && checkOutInput) {
                    checkOutInput.min = checkIn || '';
                }

                if (!checkIn || !checkOut) {
                    nightsInput.value = 0;
                    return 0;
                }

                const start = new Date(checkIn);
                const end = new Date(checkOut);
                const diff = end.getTime() - start.getTime();

                if (diff <= 0) {
                    nightsInput.value = 0;
                    return 0;
                }

                const nights = Math.ceil(diff / (1000 * 60 * 60 * 24));
                nightsInput.value = nights;
                return nights;
            }

            function getSelectedServices() {
                const selectedServices = [];

                serviceCheckboxes.forEach(function (checkbox) {
                    const card = checkbox.closest('.booking-services__card');

                    if (checkbox.checked) {
                        selectedServices.push({
                            name: checkbox.dataset.name || '\u0414\u043e\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044c\u043d\u0430\u044f \u0443\u0441\u043b\u0443\u0433\u0430',
                            price: Number(checkbox.dataset.price || 0),
                        });
                        card?.classList.add('booking-services__card--selected');
                    } else {
                        card?.classList.remove('booking-services__card--selected');
                    }
                });

                return selectedServices;
            }

            function renderSelectedServices(selectedServices) {
                if (!summaryServices || !summaryServicesList) {
                    return;
                }

                summaryServicesList.replaceChildren();

                if (selectedServices.length === 0) {
                    summaryServices.hidden = true;
                    return;
                }

                selectedServices.forEach(function (service) {
                    const item = document.createElement('div');
                    item.className = 'booking-summary__services-item';

                    const name = document.createElement('span');
                    name.className = 'booking-summary__services-name';
                    name.textContent = service.name;

                    const price = document.createElement('strong');
                    price.className = 'booking-summary__services-price';
                    price.textContent = formatMoney(service.price);

                    item.append(name, price);
                    summaryServicesList.append(item);
                });

                summaryServices.hidden = false;
            }

            function updateSummary() {
                const guests = Math.max(parseInt(guestsInput?.value || '1', 10), 1);
                const nights = calculateNights();
                const selectedServices = getSelectedServices();
                const servicesSum = selectedServices.reduce(function (total, service) {
                    return total + service.price;
                }, 0);
                const roomSum = nights > 0 ? roomPrice * nights : 0;
                const total = roomSum + servicesSum;

                summaryGuests.textContent = guests + ' ' + (guests === 1 ? 'гость' : guests < 5 ? 'гостя' : 'гостей');
                summaryNights.textContent = nights > 0 ? String(nights) : '0';

                if (checkInInput?.value && checkOutInput?.value) {
                    summaryDates.textContent = formatDate(checkInInput.value) + ' — ' + formatDate(checkOutInput.value);
                } else {
                    summaryDates.textContent = 'Выберите даты';
                }

                renderSelectedServices(selectedServices);
                roomTotal.textContent = formatMoney(roomSum);
                grandTotal.textContent = formatMoney(total);
                if (grandTotalMobile) {
                    grandTotalMobile.textContent = formatMoney(total);
                }

                if (servicesSum > 0) {
                    servicesRow.hidden = false;
                    servicesTotal.textContent = formatMoney(servicesSum);
                } else {
                    servicesRow.hidden = true;
                    servicesTotal.textContent = formatMoney(0);
                }
            }

            ageInput?.addEventListener('keydown', function (event) {
                if (['-', '+', 'e', 'E'].includes(event.key)) {
                    event.preventDefault();
                }
            });

            ageInput?.addEventListener('input', function () {
                if (ageInput.value === '') {
                    return;
                }

                const normalizedAge = Math.min(Math.max(parseInt(ageInput.value, 10) || 0, 0), 120);
                ageInput.value = String(normalizedAge);
            });

            guestsInput?.addEventListener('input', updateSummary);
            checkInInput?.addEventListener('change', updateSummary);
            checkOutInput?.addEventListener('change', updateSummary);

            serviceCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', updateSummary);
            });

            updateSummary();
        });
    </script>
@endsection
