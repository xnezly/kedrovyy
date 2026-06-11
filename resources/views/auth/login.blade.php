@extends('theme')
@section('title', 'Вход')
@section('content')
    <div class="auth-page">
        <div class="auth-page__container">
            <div class="auth-card">

                <div class="auth-card__header">
                    <h1 class="auth-card__title">Вход</h1>
                    <p class="auth-card__subtitle">Войдите для управления бронированиями</p>
                </div>

                <div class="auth-card__body">
                    @if($errors->any())
                        <div class="auth-alert" role="alert">
                            <svg class="auth-alert__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <div class="auth-alert__content">
                                <h6 class="auth-alert__heading">Ошибка входа:</h6>
                                <ul class="auth-alert__list">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="/login" method="post" class="auth-form">
                        @csrf

                        <div class="auth-form__field">
                            <div class="auth-form__input-wrapper">
                                <input type="tel"
                                       class="auth-form__input @error('phone') auth-form__input--invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       placeholder=" "
                                       value="{{ old('phone') }}"
                                       data-phone-mask>
                                <label class="auth-form__label" for="login_phone">Номер телефона</label>
                            </div>
                            @error('phone')
                            <span class="auth-form__error">{{ $message }}</span>
                            @enderror
                            <small class="auth-form__hint">Пример: +7 (999) 123-45-67</small>
                        </div>

                        <div class="auth-form__field">
                            <div class="auth-form__input-wrapper">
                                <input type="password"
                                       class="auth-form__input @error('password') auth-form__input--invalid @enderror"
                                       id="login_password"
                                       name="password"
                                       placeholder=" ">
                                <label class="auth-form__label" for="login_password">Пароль</label>
                            </div>
                            @error('password')
                            <span class="auth-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="auth-form__checkbox-wrapper">
                            <input type="hidden" name="remember" value="0">
                            <input type="checkbox"
                                   class="auth-form__checkbox"
                                   id="remember_me"
                                   name="remember"
                                   value="1"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="auth-form__checkbox-label" for="remember_me">
                                Запомнить меня
                            </label>
                        </div>

                        <button type="submit" class="auth-form__submit">Войти</button>

                        <div class="auth-form__switch">
                            Нет аккаунта?
                            <a href="/register">Зарегистрироваться</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/imask"></script>
    <script src="{{ asset('js/phone-mask.js') }}"></script>
@endpush
