@extends('theme')
@section('title', 'Описание')
@section('content')
    <div class="desc">
        <div class="desc__container">
            <section class="desc__section">
                <h2 class="desc__header">Описание</h2>
                <p class="desc__text">
                    Гостевой дом «Кедровый» предлагает уникальную возможность насладиться природой и комфортом.
                    Мы располагаем уютными номерами, которые идеально подходят для отдыха с семьей или друзьями.
                </p>
            </section>

            <section class="desc__section">
                <h2 class="desc__header">Местоположение</h2>
                <p class="desc__text">
                    Наш гостевой дом расположен в живописном городе Абаза, всего в двух часах езды от краевого центра
                    Республики Хакасия. Окруженный первозданной таежной природой, вы сможете насладиться тишиной и
                    спокойствием, вдали от городской суеты.
                </p>
            </section>

            <section class="desc__section">
                <h2 class="desc__header">Удобства</h2>
                <ul class="features-list">
                    <li class="features-list__item">
                        <span class="features-list__icon">✓</span>
                        <span class="features-list__text">Комфортабельные номера с современными удобствами</span>
                    </li>
                    <li class="features-list__item">
                        <span class="features-list__icon">✓</span>
                        <span class="features-list__text">Бесплатный Wi-Fi на всей территории</span>
                    </li>
                    <li class="features-list__item">
                        <span class="features-list__icon">✓</span>
                        <span class="features-list__text">Кухня для самостоятельного приготовления пищи</span>
                    </li>
                    <li class="features-list__item">
                        <span class="features-list__icon">✓</span>
                        <span class="features-list__text">Парковка для автомобилей</span>
                    </li>
                    <li class="features-list__item">
                        <span class="features-list__icon">✓</span>
                        <span class="features-list__text">Баня и зона для барбекю</span>
                    </li>
                </ul>
            </section>

            <section class="desc__section">
                <h2 class="desc__header">Активности</h2>
                <p class="desc__text">В нашем доме вы найдете множество возможностей для активного отдыха:</p>
                <ul class="activities-list">
                    <li class="activities-list__item">
                        <span class="activities-list__icon">•</span>
                        <span class="activities-list__text">Экскурсии по живописным местам региона</span>
                    </li>
                    <li class="activities-list__item">
                        <span class="activities-list__icon">•</span>
                        <span class="activities-list__text">Рыбалка на реке</span>
                    </li>
                    <li class="activities-list__item">
                        <span class="activities-list__icon">•</span>
                        <span class="activities-list__text">Охота в окрестных лесах</span>
                    </li>
                    <li class="activities-list__item">
                        <span class="activities-list__icon">•</span>
                        <span class="activities-list__text">Прогулки на катере по реке</span>
                    </li>
                    <li class="activities-list__item">
                        <span class="activities-list__icon">•</span>
                        <span class="activities-list__text">Пешие прогулки и походы по живописным тропам</span>
                    </li>
                </ul>
            </section>

            <section class="desc__section">
                <h2 class="desc__header">Отзывы гостей</h2>

                <div class="review">
                    <span class="review__author">✎ Анна и Сергей</span>
                    <p class="review__text">
                        «Отдыхали с семьей в гостевом доме «Кедровый» и остались в полном восторге!
                        Прекрасная природа, уютные номера и доброжелательный персонал. Обязательно вернемся!»
                    </p>
                </div>

                <div class="review">
                    <span class="review__author">✎ Игорь</span>
                    <p class="review__text">
                        «Замечательное место для отдыха! Мы провели незабываемые выходные, наслаждаясь
                        рыбалкой и прогулками по лесу. Рекомендуем всем!»
                    </p>
                </div>
            </section>
        </div>

@endsection
