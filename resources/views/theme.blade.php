<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>@yield('title', '')</title>
</head>
<body>
<header class="header">
    <div class="header__top">
        <!-- Кнопка Бургер (видна только на мобильных) -->
        <button class="burger-btn d-lg-none" id="burgerBtn" aria-label="Открыть меню">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Логотип по центру -->
        <div class="logo-wrapper text-center flex-grow-1">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Кедровый" style="max-height: 200px;">
            </a>
        </div>

        <!-- Кнопки входа/регистрации (только на десктопе) -->
        <div class="auth-buttons d-none d-lg-flex align-items-center gap-3">
            @guest()
                <a href="/login" class="button btn--outline-pill">Вход</a>
                <a href="/register" class="button btn--success-pill">Регистрация</a>
            @endguest

            @auth()
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.applications.index') }}" class="nav-link text-success fw-semibold small">Заявки</a>
                    <a href="{{ route('admin.services.index') }}" class="nav-link text-success fw-semibold small">Услуги</a>
                    <a href="{{ route('admin.rooms.index') }}" class="nav-link text-success fw-semibold small">Номера</a>
                @endif

                <span class="text-success fw-semibold me-2 small">{{ Auth::user()->name }}</span>
                <a href="{{ route('applications.index') }}" class="btn btn--outline-pill btn-sm">Кабинет</a>

                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn--danger btn-sm p-1" title="Выйти">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Навигационное меню (скрыто на мобильных, открывается по клику) -->
    <nav class="main-nav" id="mainNav">
        <div class="container">
            <div class="nav-wrapper">
                <!-- Основные ссылки -->
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">ГЛАВНАЯ</a>
                <span class="nav-separator">|</span>
                <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">ОПИСАНИЕ</a>
                <span class="nav-separator">|</span>
                <a href="/rooms" class="nav-link {{ request()->is('rooms') ? 'active' : '' }}">НОМЕРА</a>
                <span class="nav-separator">|</span>
                <a href="/booking" class="nav-link {{ request()->is('booking') ? 'active' : '' }}">БРОНИРОВАНИЕ</a>
                <span class="nav-separator">|</span>
                <a href="/contacts" class="nav-link {{ request()->is('contacts') ? 'active' : '' }}">КОНТАКТЫ</a>

                <!-- Мобильные кнопки авторизации (внутри меню, видны только на мобильных) -->
                <div class="auth-buttons-mobile d-lg-none w-100 border-top pt-3 mt-3 d-flex flex-column gap-2 align-items-center">
                    @guest()
                        <a href="/login" class="button btn--outline-pill w-100 text-center">Вход</a>
                        <a href="/register" class="button btn--success-pill w-100 text-center">Регистрация</a>
                    @endguest

                    @auth()
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.applications.index') }}" class="nav-link text-success fw-bold w-100 text-center">Заявки</a>
                            <a href="{{ route('admin.services.index') }}" class="nav-link text-success fw-bold w-100 text-center">Услуги</a>
                            <a href="{{ route('admin.rooms.index') }}" class="nav-link text-success fw-bold w-100 text-center">Номера</a>
                        @endif

                        <div class="w-100 bg-light p-2 rounded text-center">
                            <span class="text-success fw-bold mb-0 d-block">{{ Auth::user()->name }}</span>
                            <a href="{{ route('applications.index') }}" class="btn btn--outline-pill btn-sm w-100 mt-1">Кабинет</a>
                        </div>

                        <form action="/logout" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn--danger w-100 d-flex justify-content-center align-items-center gap-2">
                                Выйти
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Promo Bar -->
    <div class="promo-bar alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert">
        <div class="container text-center">
            <small>Специальное предложение! Скидка 10% на все номера при бронировании на 3 ночи!</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</header>
<main style="flex: 1 0 auto">
    @yield('content', '')
</main>
<footer class="footer">
    <div class="footer__nav">
        <div class="footer__column">
            <h5 class="footer__title">Контактная информация</h5>
            <div class="footer__content">
                <p class="footer__link">Информация</p>
            </div>
        </div>
        <div class="footer__column">
            <h5 class="footer__title">Полезные ссылки</h5>
            <div class="footer__content">
                <a href="/" class="footer__link {{ request()->is('/') ? 'active' : '' }}">Главная</a>
                <a href="/about" class="footer__link {{ request()->is('about') ? 'active' : '' }}">Описание</a>
                <a href="/rooms" class="footer__link {{ request()->is('rooms') ? 'active' : '' }}">Номера</a>
                <a href="/contacts" class="footer__link {{ request()->is('contacts') ? 'active' : '' }}">Контакты</a>
            </div>
        </div>
        <div class="footer__column">
            <h5 class="footer__title">Мы в социальных сетях</h5>
            <div class="footer__content">
                <div class="social-links">
                    <a href="https://instagram.com" target="_blank" class="social-link" title="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                             viewBox="0 0 16 16">
                            <path
                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/burger.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
@stack('scripts')
</body>
</html>
