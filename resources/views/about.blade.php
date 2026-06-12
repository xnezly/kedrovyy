@extends('theme')

@section('title', 'Описание')

@section('content')
    @php
        $galleryImages = [
            '6.webp',
            'pole.webp',
            '18.webp',
            '15.webp',
            '13.webp',
            '7.webp',
            '14.webp',
            '19.webp',
        ];
    @endphp

    <div class="desc">
        <div class="desc__container">
            <section class="desc__hero">
                <div class="desc__hero-copy">
                    <h1 class="desc__title">Отдых в тишине, среди природы и домашнего уюта</h1>
                    <p class="desc__lead">
                        «Кедровый» в Абазе создан для тех, кто хочет замедлиться, подышать чистым воздухом,
                        провести время с близкими и почувствовать настоящее спокойствие вдали от городского шума.
                    </p>

                    <div class="desc__meta">
                        <div class="desc__meta-item">
                            
                            <span>Республика Хакасия, г. Абаза, рядом с лесом и живописной природой</span>
                        </div>
                        <div class="desc__meta-item">
                         
                            <span>Уютные номера, домашняя атмосфера и комфорт для семейного отдыха</span>
                        </div>
                        <div class="desc__meta-item">
                           
                            <span>Баня, беседка, прогулки, рыбалка и размеренный отдых в красивом месте</span>
                        </div>
                    </div>
                </div>

                <div class="desc__hero-visual">
                    <img
                        src="{{ asset('img/dom.webp') }}"
                        alt="Гостевой дом Кедровый"
                        class="desc__hero-image"
                    >
                </div>
            </section>

            <section class="desc__section">
                <div class="desc__section-head">
                    <h2 class="desc__section-title">Почему гостям здесь действительно комфортно</h2>
                    <p class="desc__section-text">
                        Мы постарались собрать все, что делает отдых удобным, теплым и запоминающимся.
                    </p>
                </div>

                <div class="desc-features">
                    <article class="desc-feature">
                        <div class="desc-feature__icon">
                            <i class="bi bi-door-open-fill" aria-hidden="true"></i>
                        </div>
                        <h3 class="desc-feature__title">Уютные номера</h3>
                        <p class="desc-feature__text">
                            Комфортное размещение, продуманная обстановка и приятная атмосфера для спокойного отдыха.
                        </p>
                    </article>

                    <article class="desc-feature">
                        <div class="desc-feature__icon">
                            <i class="bi bi-wifi" aria-hidden="true"></i>
                        </div>
                        <h3 class="desc-feature__title">Wi-Fi на территории</h3>
                        <p class="desc-feature__text">
                            Интернет всегда под рукой, если нужно оставаться на связи или делиться впечатлениями.
                        </p>
                    </article>

                    <article class="desc-feature">
                        <div class="desc-feature__icon">
                            <i class="bi bi-cup-hot-fill" aria-hidden="true"></i>
                        </div>
                        <h3 class="desc-feature__title">Кухня и бытовой комфорт</h3>
                        <p class="desc-feature__text">
                            Все необходимое, чтобы готовить еду самостоятельно и чувствовать себя как дома.
                        </p>
                    </article>

                    <article class="desc-feature">
                        <div class="desc-feature__icon">
                            <i class="bi bi-p-square-fill" aria-hidden="true"></i>
                        </div>
                        <h3 class="desc-feature__title">Парковка</h3>
                        <p class="desc-feature__text">
                            Удобное размещение автомобиля на территории для спокойного и комфортного приезда.
                        </p>
                    </article>

                    <article class="desc-feature">
                        <div class="desc-feature__icon">
                            <i class="bi bi-fire" aria-hidden="true"></i>
                        </div>
                        <h3 class="desc-feature__title">Баня и зона отдыха</h3>
                        <p class="desc-feature__text">
                            Теплая баня и уютное место для приятных вечеров после насыщенного дня.
                        </p>
                    </article>

                    <article class="desc-feature">
                        <div class="desc-feature__icon">
                            <i class="bi bi-tree-fill" aria-hidden="true"></i>
                        </div>
                        <h3 class="desc-feature__title">Природа вокруг</h3>
                        <p class="desc-feature__text">
                            Лес, свежий воздух и красивые виды создают ощущение настоящего отдыха от города.
                        </p>
                    </article>
                </div>
            </section>

            <section class="desc__section">
                <div class="desc__section-head">
                    <h2 class="desc__section-title">Чем можно заняться во время отдыха</h2>
                    <p class="desc__section-text">
                        Здесь легко выбрать ритм под себя: активный, расслабленный или что-то между ними.
                    </p>
                </div>

                <div class="desc-activities">
                    <article class="desc-activity">
                        <div class="desc-activity__icon">
                            <i class="bi bi-signpost-split-fill" aria-hidden="true"></i>
                        </div>
                        <div class="desc-activity__content">
                            <h3 class="desc-activity__title">Прогулки и маршруты</h3>
                            <p class="desc-activity__text">
                                Неспешные прогулки по живописным местам, лесным тропам и окрестностям Абазы.
                            </p>
                        </div>
                    </article>

                    <article class="desc-activity">
                        <div class="desc-activity__icon">
                            <i class="bi bi-water" aria-hidden="true"></i>
                        </div>
                        <div class="desc-activity__content">
                            <h3 class="desc-activity__title">Рыбалка и отдых у воды</h3>
                            <p class="desc-activity__text">
                                Отличный вариант для тех, кто любит спокойствие, природу и время наедине с собой.
                            </p>
                        </div>
                    </article>

                    <article class="desc-activity">
                        <div class="desc-activity__icon">
                            <i class="bi bi-camera-fill" aria-hidden="true"></i>
                        </div>
                        <div class="desc-activity__content">
                            <h3 class="desc-activity__title">Красивые виды и фото</h3>
                            <p class="desc-activity__text">
                                Территория и окрестности подходят для атмосферных кадров и теплых семейных снимков.
                            </p>
                        </div>
                    </article>

                    <article class="desc-activity">
                        <div class="desc-activity__icon">
                            <i class="bi bi-moon-stars-fill" aria-hidden="true"></i>
                        </div>
                        <div class="desc-activity__content">
                            <h3 class="desc-activity__title">Тихие вечера</h3>
                            <p class="desc-activity__text">
                                Беседка, общение, баня и неспешный отдых помогают по-настоящему перезагрузиться.
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section class="desc__section">
                <div class="desc__section-head">
                    <h2 class="desc__section-title">Гости возвращаются сюда за атмосферой</h2>
                    <p class="desc__section-text">
                        Самое ценное для нас — когда отдых запоминается теплом, уютом и желанием вернуться снова.
                    </p>
                </div>

                <div class="desc-reviews">
                    <article class="desc-review">
                        <div class="desc-review__rating">★★★★★</div>
                        <p class="desc-review__text">
                            «Отдыхали здесь семьей и остались в полном восторге. Очень уютно, красиво и спокойно.
                            Природа вокруг просто замечательная, а атмосфера действительно домашняя.»
                        </p>
                        <span class="desc-review__author">Анна и Сергей</span>
                    </article>

                    <article class="desc-review">
                        <div class="desc-review__rating">★★★★★</div>
                        <p class="desc-review__text">
                            «Отличное место для выходных. Понравились тишина, свежий воздух и возможность хорошо
                            отдохнуть от городской суеты. Хочется приехать еще раз.»
                        </p>
                        <span class="desc-review__author">Игорь</span>
                    </article>

                    <article class="desc-review">
                        <div class="desc-review__rating">★★★★★</div>
                        <p class="desc-review__text">
                            «Очень приятное место с теплой атмосферой. Все выглядит ухоженно, а сам отдых получился
                            спокойным и по-настоящему душевным.»
                        </p>
                        <span class="desc-review__author">Марина</span>
                    </article>
                </div>
            </section>

            <section class="desc__section desc__section--gallery">
                <div class="desc__section-head">
                    <h2 class="desc__section-title">Посмотрите на атмосферу «Кедрового»</h2>
                    <p class="desc__section-text">
                        Несколько кадров, которые помогают почувствовать настроение дома еще до приезда.
                    </p>
                </div>

                <div class="desc-gallery">
                    @foreach ($galleryImages as $index => $image)
                        <figure class="desc-gallery__item">
                            <button
                                type="button"
                                class="desc-gallery__trigger"
                                data-desc-gallery-trigger
                                data-desc-gallery-src="{{ asset('img/' . $image) }}"
                                data-desc-gallery-alt="Фото гостевого дома Кедровый {{ $index + 1 }}"
                                aria-label="Открыть фото {{ $index + 1 }}"
                            >
                                <img
                                src="{{ asset('img/' . $image) }}"
                                alt="Фото гостевого дома Кедровый {{ $index + 1 }}"
                                class="desc-gallery__image"
                                loading="lazy"
                            >
                            </button>
                        </figure>
                    @endforeach
                </div>
            </section>

            <div class="desc-gallery-lightbox" id="descGalleryLightbox" hidden>
                <button
                    type="button"
                    class="desc-gallery-lightbox__backdrop"
                    data-desc-gallery-close
                    aria-label="Закрыть просмотр"
                ></button>

                <div
                    class="desc-gallery-lightbox__dialog"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Просмотр изображения"
                >
                    <button
                        type="button"
                        class="desc-gallery-lightbox__close"
                        data-desc-gallery-close
                        aria-label="Закрыть просмотр"
                    >
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </button>

                    <img
                        src=""
                        alt=""
                        class="desc-gallery-lightbox__image"
                        id="descGalleryLightboxImage"
                    >

                    <p class="desc-gallery-lightbox__caption" id="descGalleryLightboxCaption"></p>
                </div>
            </div>

            <section class="desc__cta">
                <div class="desc__cta-copy">
                    <h2 class="desc__cta-title">Подберите номер и запланируйте поездку в «Кедровый»</h2>
                    <p class="desc__cta-text">
                        Посмотрите доступные номера, оцените условия проживания и выберите вариант,
                        который подойдет именно вам.
                    </p>
                </div>

                <div class="desc__cta-actions">
                    <a href="{{ route('rooms.index') }}" class="desc__cta-btn desc__cta-btn--primary">Смотреть номера</a>
                    <a href="{{ route('contacts') }}" class="desc__cta-btn desc__cta-btn--secondary">Связаться с нами</a>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer src="{{ asset('js/about-gallery.js') }}"></script>
@endpush
