<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monomakh&family=Oswald:wght@200..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Yanone+Kaffeesatz:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <script src="{{ asset('js/page-transition-head.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @stack('styles')
    <title>@yield('title', 'Кедровый')</title>
</head>
<body>
<div class="page-transition-layer" id="pageTransitionLayer" aria-hidden="true"></div>
<header class="header">
    <div class="header__top">
        <button class="burger-btn d-lg-none" id="burgerBtn" aria-label="Открыть меню">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="logo-wrapper text-center flex-grow-1">
            <a href="/">
                <img src="{{ asset('img/logo.webp') }}" alt="Кедровый" style="max-height: 200px;">
            </a>
        </div>

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

    <nav class="main-nav" id="mainNav">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">ГЛАВНАЯ</a>
                <span class="nav-separator">|</span>
                <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">ОПИСАНИЕ</a>
                <span class="nav-separator">|</span>
                <a href="/rooms" class="nav-link {{ request()->is('rooms') ? 'active' : '' }}">НОМЕРА</a>
                <span class="nav-separator">|</span>
                <a href="/booking" class="nav-link {{ request()->is('booking') ? 'active' : '' }}">БРОНИРОВАНИЕ</a>
                <span class="nav-separator">|</span>
                <a href="/contacts" class="nav-link {{ request()->is('contacts') ? 'active' : '' }}">КОНТАКТЫ</a>

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
</header>

<main style="flex: 1 0 auto">
    @yield('content', '')
</main>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-section footer-info">
            <h3>Контактная информация</h3>
            <div class="footer-contact-item">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z"/>
                </svg>
                <span class="footer-contact-text">РХ, г. Абаза, ул. Мичурина, 60</span>
            </div>
            <div class="footer-contact-item">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m16.56 12.91-.45.45s-1.08 1.08-4.04-1.86c-2.95-2.94-1.87-4.01-1.87-4.01l.29-.29c.7-.7.77-1.83.15-2.65L9.37 2.86c-.76-1.02-2.24-1.16-3.11-.29L4.69 4.14c-.43.43-.72.99-.69 1.61.09 1.59.81 5 4.81 8.98 4.25 4.22 8.23 4.39 9.87 4.24a2.05 2.05 0 0 0 1.32-.67l1.42-1.42c.96-.95.69-2.59-.54-3.26l-1.91-1.04a1.88 1.88 0 0 0-2.42.33Z"/>
                </svg>
                <a href="tel:+79831953745" class="footer-contact-link">+7 (983) 195-37-45</a>
            </div>
            <div class="footer-contact-item">
                <svg viewBox="0 0 32 32" aria-hidden="true">
                    <path d="M30 9.9v13.1c0 2.8-2.2 5-5 5H7c-2.8 0-5-2.2-5-5V9.9l14 8.9 14-8.9ZM16 2.2 27.2 10 16 16.8 4.8 10 16 2.2Z"/>
                </svg>
                <a href="mailto:choporov.yura@mail.ru" class="footer-contact-link">choporov.yura@mail.ru</a>
            </div>
        </div>

        <div class="footer-section footer-links">
            <h3>Полезные ссылки</h3>
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Описание</a></li>
                <li><a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">Номера</a></li>
                <li><a href="{{ route('booking') }}" class="{{ request()->routeIs('booking') ? 'active' : '' }}">Бронирование</a></li>
                <li><a href="{{ route('contacts') }}" class="{{ request()->routeIs('contacts') ? 'active' : '' }}">Контакты</a></li>
            </ul>
        </div>

        <div class="footer-section footer-social">
            <h3>Мы в социальных сетях</h3>
            <div class="social-icons">
                <a href="https://www.instagram.com/gostevoy.dom.kedroviy?igsh=MTQ3Zmo1b3lqa2sxdA==" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 0 1 12 7.5Zm0 2A2.5 2.5 0 1 0 14.5 12 2.5 2.5 0 0 0 12 9.5Zm5.25-3.25a1.25 1.25 0 1 1-1.25 1.25 1.25 1.25 0 0 1 1.25-1.25Z"/>
                    </svg>
                </a>
                <a href="https://vk.com/gostevoy.dom.kedroviy" target="_blank" rel="noopener noreferrer" aria-label="ВКонтакте">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12.79 17.6h1.43s.43-.05.65-.28c.2-.21.2-.61.2-.61s-.03-1.85.83-2.12c.85-.26 1.94 1.79 3.1 2.58.87.6 1.53.47 1.53.47l3.08-.04s1.6-.1.84-1.37c-.06-.1-.45-.95-2.33-2.69-1.97-1.82-1.71-1.53.67-4.7 1.45-1.93 2.03-3.1 1.85-3.6-.17-.47-1.2-.35-1.2-.35l-3.47.02s-.26-.04-.45.08c-.18.12-.3.4-.3.4s-.55 1.47-1.29 2.71c-1.56 2.62-2.18 2.75-2.44 2.58-.6-.38-.45-1.54-.45-2.37 0-2.57.39-3.64-.76-3.92-.38-.09-.66-.15-1.63-.16-1.24-.01-2.29 0-2.88.29-.39.19-.69.62-.5.64.23.03.76.14 1.03.5.35.46.34 1.49.34 1.49s.2 3.02-.47 3.4c-.46.26-1.09-.27-2.44-2.63A22.39 22.39 0 0 1 5.43 5.6s-.1-.27-.29-.41c-.22-.17-.52-.22-.52-.22l-3.3.02s-.5.01-.68.24c-.16.2-.01.6-.01.6s2.58 6.03 5.5 9.06C8.82 17.67 11.95 17.6 12.79 17.6Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">© {{ now()->year }} «Кедровый»</div>
</footer>

<div class="promo-toast" id="promoToast" role="status" aria-live="polite">
    <div class="promo-toast__icon" aria-hidden="true">
        <i class="bi bi-percent"></i>
    </div>
    <div class="promo-toast__content">
        <span class="promo-toast__label">Спецпредложение</span>
        <p class="promo-toast__text">Скидка 10% на все номера при бронировании на 3 ночи!</p>
    </div>
    <button type="button" class="promo-toast__close" id="promoToastClose" aria-label="Закрыть уведомление">
        <i class="bi bi-x-lg"></i>
    </button>
</div>

<!-- Yandex.Metrika counter -->
<script defer src="{{ asset('js/yandex-metrika.js') }}"></script>
<noscript><div><img src="https://mc.yandex.ru/watch/109240491" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="{{ asset('js/burger.js') }}"></script>
<script defer src="{{ asset('js/index.js') }}"></script>
<script defer src="{{ asset('js/page-transition.js') }}"></script>
<script defer src="{{ asset('js/promo-toast.js') }}"></script>
@stack('scripts')
</body>
</html>
