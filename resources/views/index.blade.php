@extends('theme')
@section('title', 'Главная')
@section('content')

    <section class="home-hero">
        <div class="carousel" id="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img
                        src="{{ asset('img/1.webp') }}"
                        alt="Гостевой дом Кедровый"
                    />
                    <div class="carousel-caption">
                        <span class="carousel-caption__eyebrow">Гостевой дом «Кедровый»</span>
                        <h3 class="carousel-caption__title">Теплый отдых среди природы, тишины и домашнего уюта</h3>
                        <p class="carousel-caption__text">
                            Комфортные номера, спокойная атмосфера и красивый вид вокруг, чтобы отдохнуть без спешки и суеты.
                        </p>
                        <div class="carousel-caption__actions">
                            <a href="{{ route('rooms.index') }}" class="carousel-caption__button carousel-caption__button--solid">Смотреть номера</a>
                            <a href="{{ route('about') }}" class="carousel-caption__button carousel-caption__button--ghost">Подробнее о доме</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img
                        src="{{ asset('img/pole.webp') }}"
                        alt="Природа рядом с гостевым домом"
                    />
                    <div class="carousel-caption">
                        <span class="carousel-caption__eyebrow">Абаза, Хакасия</span>
                        <h3 class="carousel-caption__title">Река, лес и воздух, в который хочется возвращаться</h3>
                        <p class="carousel-caption__text">
                            Здесь легко переключиться на размеренный ритм: прогулки, рыбалка, отдых в беседке и долгие тихие вечера.
                        </p>
                        <div class="carousel-caption__actions">
                            <a href="{{ route('contacts') }}" class="carousel-caption__button carousel-caption__button--solid">Как нас найти</a>
                            <a href="{{ route('booking') }}" class="carousel-caption__button carousel-caption__button--ghost">Условия бронирования</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img
                        src="{{ asset('img/kypel.webp') }}"
                        alt="Баня и купель"
                    />
                    <div class="carousel-caption">
                        <span class="carousel-caption__eyebrow">Отдых с атмосферой</span>
                        <h3 class="carousel-caption__title">Баня, купель и приятные мелочи для полного расслабления</h3>
                        <p class="carousel-caption__text">
                            После прогулок можно согреться в бане, провести вечер в компании близких и по-настоящему выдохнуть.
                        </p>
                        <div class="carousel-caption__actions">
                            <a href="{{ route('booking') }}" class="carousel-caption__button carousel-caption__button--solid">Оставить заявку</a>
                            <a href="{{ route('about') }}" class="carousel-caption__button carousel-caption__button--ghost">Посмотреть атмосферу</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control prev" id="prev" type="button" aria-label="Предыдущий слайд">❮</button>
            <button class="carousel-control next" id="next" type="button" aria-label="Следующий слайд">❯</button>
        </div>

        <section class="descript">
            <div class="descript__wrap">
                <div class="descript__intro">
                    <h2 class="descript__title">Место, где природа, уют и спокойствие собираются в один настоящий отдых</h2>
                    <p class="descript__lead">
                        Гостевой дом «Кедровый» расположен на берегу реки Абакан, рядом с лесом и красивой хакасской природой.
                        Сюда приезжают за тишиной, домашней атмосферой и комфортным проживанием в аккуратных номерах со всеми удобствами.
                    </p>
                    <p class="descript__lead">
                        Здесь можно гулять, отдыхать в беседке, проводить время у воды, рыбачить и расслабляться в бане с купелью.
                        Мы постарались сделать отдых таким, чтобы хотелось не просто приехать однажды, а возвращаться снова.
                    </p>
                </div>

                <div class="descript__facts">
                    <div class="descript__fact">
                        <span class="descript__fact-label">Локация</span>
                        <strong class="descript__fact-value">Берег реки Абакан</strong>
                    </div>
                    <div class="descript__fact">
                        <span class="descript__fact-label">Формат</span>
                        <strong class="descript__fact-value">Уютный отдых для семьи и компании</strong>
                    </div>
                    <div class="descript__fact">
                        <span class="descript__fact-label">Атмосфера</span>
                        <strong class="descript__fact-value">Тишина, природа и домашний комфорт</strong>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <section class="about-views">
        <div class="about-views__header">
            <h2 class="about-views__title">Красивые виды на отдыхе</h2>
        </div>

        <div class="about__container">
        <article class="about__item">
            <img src="{{ asset('img/vid1.webp') }}" class="about__img" alt="Вид 1">
            <div class="about__text">
                <h5 class="about__title">Абаза встречает красивыми видами уже с дороги</h5>
                <p class="about__description">
                    По пути сюда сразу чувствуется особая атмосфера места: горы на горизонте,
                    густой лес вокруг и ощущение, что впереди вас ждет спокойный отдых
                    вдали от городского шума.
                </p>
            </div>
        </article>

        <article class="about__item about__item--reverse">
            <img src="{{ asset('img/becedka.webp') }}" class="about__img" alt="Вид 2">
            <div class="about__text">
                <h5 class="about__title">Беседка у реки</h5>
                <p class="about__description">
                    Здесь приятно встретить утро с чашкой чая, посидеть в тени сосен днем
                    или просто провести вечер рядом с рекой, наслаждаясь тишиной и природой.
                </p>
            </div>
        </article>

        <article class="about__item">
            <img src="{{ asset('img/vid4.webp') }}" class="about__img" alt="Вид 3">
            <div class="about__text">
                <h5 class="about__title">Река у берега</h5>
                <p class="about__description">
Лодки, спокойная вода и зелёные склоны — тут не нужно придумывать развлечения. Всё уже сделано природой: половить рыбу, пройтись по берегу или просто сидеть и смотреть на воду. Здесь отдых случается сам собой.
                </p>
            </div>
        </article>

        <article class="about__item about__item--reverse">
            <img src="{{ asset('img/les.webp') }}" class="about__img" alt="Вид 4">
            <div class="about__text">
                <h5 class="about__title">Прогулка по лесу</h5>
                <p class="about__description">
Тропинка ведёт прямо из домика в чащу. Солнечные зайчики на тропе, хвойный воздух и шелест деревьев создают то самое состояние, когда телефон можно убрать в карман, а плечи сами расправляются. Место, куда хочется возвращаться за тишиной.
                </p>
            </div>
        </article>
        </div>
    </section>

     <section class="faq" aria-labelledby="faq-title">
        <div class="faq__header">
            <h1 class="faq-title" id="faq-title">Часто задаваемые вопросы</h1>
            <p class="faq__subtitle">
                Собрали самые частые вопросы о проживании, территории и бронировании,
                чтобы нужные ответы были под рукой еще до поездки.
            </p>
        </div>

        <div class="faq-list">
            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-1" id="faq-question-1">
                    <span class="faq-question__text">Во сколько заезд и выезд?</span>
                    <span class="faq-question__icon">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div class="faq-answer" id="faq-answer-1" role="region" aria-labelledby="faq-question-1" hidden>
                    <div class="faq-answer__inner">
                        <p>
                            Стандартное время заезда — 14:00, выезда — 12:00. По предварительной договоренности
                            можно обсудить ранний заезд или более поздний выезд, если номер свободен.
                        </p>
                    </div>
                </div>
            </article>

            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-2" id="faq-question-2">
                    <span class="faq-question__text">Что нужно брать с собой для проживания?</span>
                    <span class="faq-question__icon">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div class="faq-answer" id="faq-answer-2" role="region" aria-labelledby="faq-question-2" hidden>
                    <div class="faq-answer__inner">
                        <p>
                            Мы предоставляем постельное белье, полотенца и базовый набор удобств. С собой лучше
                            взять удобную одежду для прогулок, личные вещи и все, что сделает ваш отдых еще комфортнее.
                        </p>
                    </div>
                </div>
            </article>

            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-3" id="faq-question-3">
                    <span class="faq-question__text">Чем можно заняться на территории?</span>
                    <span class="faq-question__icon">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div class="faq-answer" id="faq-answer-3" role="region" aria-labelledby="faq-question-3" hidden>
                    <div class="faq-answer__inner">
                        <p>
                            Гости гуляют по лесу, отдыхают у реки, рыбачат, собираются в беседке и жарят шашлыки.
                            Для более расслабленного отдыха можно отдельно забронировать баню с купелью.
                        </p>
                    </div>
                </div>
            </article>

            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-4" id="faq-question-4">
                    <span class="faq-question__text">Сколько стоит аренда бани?</span>
                    <span class="faq-question__icon">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div class="faq-answer" id="faq-answer-4" role="region" aria-labelledby="faq-question-4" hidden>
                    <div class="faq-answer__inner">
                        <p>
                            Аренда бани начинается от 1000 рублей в час. Точная стоимость зависит от времени,
                            дня недели и сезона, поэтому актуальную цену лучше уточнять при бронировании.
                        </p>
                    </div>
                </div>
            </article>

            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-5" id="faq-question-5">
                    <span class="faq-question__text">Нужно ли заранее бронировать номер или баню?</span>
                    <span class="faq-question__icon">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div class="faq-answer" id="faq-answer-5" role="region" aria-labelledby="faq-question-5" hidden>
                    <div class="faq-answer__inner">
                        <p>
                            Да, лучше бронировать заранее. Особенно это важно в выходные и праздничные дни,
                            когда спрос выше и хочется спокойно выбрать удобные даты без спешки.
                        </p>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
