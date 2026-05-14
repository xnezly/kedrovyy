@extends('theme')
@section('title', 'Контакты')
@section('content')
    <div class="contacts">
        <div class="contacts__container">
            <div class="contacts__card">

                <!-- Page Title -->
                <div class="contacts__header">
                    <h1 class="contacts__title">Контакты</h1>
                    <h2 class="contacts__subtitle">Свяжитесь с нами</h2>
                </div>

                <div class="contacts__grid">
                    <!-- Contact Information -->
                    <div class="contacts__info">
                        <div class="contacts__info-block">
                            <h3 class="contacts__info-label">Адрес</h3>
                            <p class="contacts__info-value">
                                Республика Хакасия, г. Абаза,<br>
                                ул. Мичурина, д. 60
                            </p>
                        </div>

                        <div class="contacts__info-block">
                            <h3 class="contacts__info-label">Телефон</h3>
                            <p class="contacts__info-value">
                                <a href="tel:+79021234567" class="contacts__link">
                                    +7 (902) 123-45-67
                                </a>
                            </p>
                            <p class="contacts__info-value contacts__info-value--secondary">
                                <a href="tel:+739012345678" class="contacts__link">
                                    +7 (39012) 3-45-67
                                </a>
                            </p>
                        </div>

                        <div class="contacts__info-block">
                            <h3 class="contacts__info-label">Email</h3>
                            <p class="contacts__info-value">
                                <a href="mailto:info@kedrovyi.ru" class="contacts__link">
                                    info@kedrovyi.ru
                                </a>
                            </p>
                            <p class="contacts__info-value contacts__info-value--secondary">
                                <a href="mailto:booking@kedrovyi.ru" class="contacts__link">
                                    booking@kedrovyi.ru
                                </a>
                            </p>
                        </div>

                        <div class="contacts__info-block">
                            <h3 class="contacts__info-label">Часы работы</h3>
                            <p class="contacts__info-value">
                                <span class="contacts__info-highlight">Круглосуточно</span>
                            </p>
                            <p class="contacts__info-note">
                                Прием гостей: с 14:00<br>
                                Освобождение номеров: до 12:00
                            </p>
                        </div>

                        <div class="contacts__info-footer">
                            <p class="contacts__info-message">
                                По всем вопросам звоните или пишите —
                                мы всегда на связи и рады помочь!
                            </p>
                        </div>
                    </div>

                    <!-- Map Section -->
                    <div class="contacts__map-wrapper">
                        <h3 class="contacts__map-title">Наша локация</h3>
                        <div class="contacts__map">
                            <iframe src="https://yandex.ru/map-widget/v1/?text=Республика+Хакасия+Абаза+Мичурина+60&z=17"
                                    class="contacts__map-frame"
                                    allowfullscreen="true">
                            </iframe>
                        </div>
                        <div class="contacts__map-link-wrapper">
                            <a href="https://yandex.ru/maps/?text=Республика+Хакасия+Абаза+Мичурина+60"
                               target="_blank"
                               class="contacts__btn contacts__btn--outline">
                                Открыть в Яндекс.Картах
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="contacts__features">
                    <div class="contacts__features-grid">
                        <div class="contacts__feature">
                            <div class="contacts__feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                            </div>
                            <h4 class="contacts__feature-title">Как добраться</h4>
                            <p class="contacts__feature-text">
                                2 часа езды от Абакана<br>по трассе Р-257
                            </p>
                        </div>

                        <div class="contacts__feature">
                            <div class="contacts__feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM8 2.5A1.5 1.5 0 0 1 9.5 1h3A1.5 1.5 0 0 1 14 2.5v3A1.5 1.5 0 0 1 12.5 7h-3A1.5 1.5 0 0 1 6.5 5.5v-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 6.5 13.5v-3zm7 0A1.5 1.5 0 0 1 9.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 8 13.5v-3z"/>
                                </svg>
                            </div>
                            <h4 class="contacts__feature-title">Трансфер</h4>
                            <p class="contacts__feature-text">
                                Организуем встречу<br>в аэропорту или на вокзале
                            </p>
                        </div>

                        <div class="contacts__feature">
                            <div class="contacts__feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77l1.75 5a.5.5 0 0 0 .65.29l1.598-.406a.5.5 0 0 0 .386-.411l.464-4.693a.678.678 0 0 0-.188-.557l-1.71-1.71zM4.5 13.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                    <path d="M11.354 5.646a.5.5 0 1 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8.5 8.293l2.854-2.854z"/>
                                    <path d="M1 14s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1v11z"/>
                                </svg>
                            </div>
                            <h4 class="contacts__feature-title">Маршрут</h4>
                            <p class="contacts__feature-text">
                                Подробная схема проезда<br>в разделе «Описание»
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
