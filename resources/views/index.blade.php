@extends('theme')
@section('title', 'Главная')
@section('content')

    <div class="carousel" id="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img
                    src="/img/1.jpg"
                    alt="Первое изображение"
                />
                <div class="carousel-caption">
                    <h3>Первое предложение</h3>
                </div>
            </div>
            <div class="carousel-item">
                <img
                    src="/img/pole.jpg"
                    alt="Второе изображение"
                />
                <div class="carousel-caption">
                    <h3>Второе предложение</h3>
                </div>
            </div>
            <div class="carousel-item">
                <img
                    src="/img/kypel.jpg"
                    alt="Третье изображение"
                />
                <div class="carousel-caption">
                    <h3>Третье предложение</h3>
                </div>
            </div>
        </div>
        <button class="carousel-control prev" id="prev">❮</button>
        <button class="carousel-control next" id="next">❯</button>
    </div>

    <div class="descript">
        <p>
            В г. Абаза, что в двух часах от езды от областного центра РХ, на самом
            берегу р. Абакан, расположен Гостевой дом "Кедровый". Приехав сюда, Вы
            сможете насладиться всем разнообразием первозданной таёжной природы. В
            этом месте царит очень уютная домашняя атмосфера, которая заставляет
            гостей возвращаться сюда опять. Размещение в гостевом доме "Кедровый"
            осуществляется в очень уютные и комфортабельные номера со всеми
            удобствами, оборудованные бытовой техникой и имеющие все необходимые
            бытовые мелочи. Для вашего досуга предусмотрена организация экскурсий,
            прогулки по берегу реки и рыбалка. А также имеется комфортабельная
            банька с купелью.
        </p>
    </div>


    <h1>Номера и цены:</h1>
    @if($rooms->isEmpty())
        <h2>Пока нет номеров</h2>
    @else
        <div class="card-container">
            @foreach($rooms as $room)
                @include('parts.room', ['room' => $room])
            @endforeach
        </div>
    @endif

    <div class="faq">
        <h1 class="faq-title">Часто задаваемые вопросы</h1>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(0)">
                Сколько стоит аренда бани?
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div class="faq-answer">
                Аренда бани начинается от 1000 рублей в час. Точная стоимость зависит от времени суток и сезона. Уточнить можно по телефону или через форму заказа.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(1)">
                Есть ли в бане купель?
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div class="faq-answer">
                Да, рядом с баней расположена открытая купель с живой водой. Попеременное чередование жара парной и прохлады купели благотворно влияет на здоровье.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(2)">
                Нужно ли предварительно бронировать?
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div class="faq-answer">
                Баня доступна по предварительной записи. Рекомендуем бронировать за несколько дней, особенно в выходные и праздничные дни.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(3)">
                Что входит в стоимость аренды?
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div class="faq-answer">
                В стоимость входит аренда бани и купели. Дополнительно можно заказать мангал, веники, чай, полотенца и другие удобства.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(4)">
                Можно ли приезжать всей семьёй?
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div class="faq-answer">
                Конечно! Баня рассчитана на комфортное размещение до 8 человек. Здесь будет уютно как большой компании, так и семье с детьми.
            </div>
        </div>
    </div>

    <h2>Красивые виды на отдыхе:</h2>

    <div class="about__container">
        <img src="{{ asset('img/vid1.png') }}" class="about__img" alt="Вид 1">
        <div class="about__text">
            <h5 class="fw-bold mb-2">Lorem ipsum dolor sit amet</h5>
            <p class="text-muted mb-0">
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Aut, earum pariatur vero dolor voluptates consectetur distinctio
                dolores odio nam, adipisci deleniti error!
            </p>
        </div>

        <div class="about__text">
            <h5 class="fw-bold mb-2">Consectetur adipisicing elit</h5>
            <p class="text-muted mb-0">
                Eius, cumque! Beatae ratione nisi perspiciatis veniam cupiditate!
                Velit, dolorum tempora quibusdam nobis sunt explicabo.
            </p>
        </div>
        <img src="{{ asset('img/vid2.png') }}" class="about__img" alt="Вид 2">

        <img src="{{ asset('img/vid3.png') }}" class="about__img" alt="Вид 3">
        <div class="about__text">
            <h5 class="fw-bold mb-2">Velit dolorum tempora quibusdam</h5>
            <p class="text-muted mb-0">
                Nobis sunt explicabo, exercitationem voluptatum architecto
                assumenda quaerat ipsam eveniet fuga perferendis.
            </p>
        </div>
        <div class="about__text">
            <h5 class="fw-bold mb-2">Architecto assumenda quaerat</h5>
            <p class="text-muted mb-0">
                Ipsam eveniet fuga perferendis, deleniti voluptate
                consectetur temporibus labore! Quis, quam distinctio.
            </p>
        </div>
        <img src="{{ asset('img/vid4.png') }}" class="about__img" alt="Вид 4">
    </div>
@endsection
