@extends('admin-theme')
@section('content')
    <div class="admin-room-form">

        {{-- Заголовок --}}
        <div class="admin-room-form__header">
            <h1 class="admin-room-form__title">Добавить услугу</h1>
            <a href="{{ route('admin.services.index') }}" class="admin-room-form__back-btn">
                ← Назад
            </a>
        </div>

        {{-- Ошибки валидации --}}
        @if($errors->any())
            <div class="admin-alert admin-alert--error">
                <ul class="admin-alert__list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.services.store') }}"
            method="post"
            enctype="multipart/form-data"
            class="admin-room-form__form"
        >
            @csrf

            <div class="admin-room-form__grid">
                {{-- Левая колонка --}}
                <div class="admin-room-form__main">

                    <div class="admin-card admin-card--form">
                        <h2 class="admin-card__subtitle">Основная информация</h2>

                        <div class="admin-form__field">
                            <label for="name" class="admin-form__label">Название услуги *</label>
                            <input
                                type="text"
                                class="admin-form__input @error('name') admin-form__input--invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Например: Баня"
                                required
                            >
                            @error('name')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form__field">
                            <label for="description" class="admin-form__label">Описание</label>
                            <textarea
                                class="admin-form__textarea @error('description') admin-form__input--invalid @enderror"
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="Описание услуги">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form__field">
                            <label for="price" class="admin-form__label">Цена (руб) *</label>
                            <input
                                type="number"
                                class="admin-form__input @error('price') admin-form__input--invalid @enderror"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                min="0"
                                required
                            >
                            @error('price')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Правая колонка (сайдбар) --}}
                <div class="admin-room-form__sidebar">
                    <div class="admin-card admin-card--sidebar">
                        <h2 class="admin-card__subtitle">Фото услуги</h2>

                        <div class="admin-form__field">
                            <label for="icon" class="admin-form__label">Загрузить фото</label>
                            <input
                                type="file"
                                class="admin-form__input-file @error('icon') admin-form__input--invalid @enderror"
                                id="icon"
                                name="icon"
                                accept="image/*"
                            >
                            <small class="admin-form__hint">JPEG, PNG, JPG (макс. 2MB)</small>
                            @error('icon')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-room-form__actions">
                            <button type="submit" class="admin-btn admin-btn--success admin-btn--full">
                                Сохранить
                            </button>
                            <a href="{{ route('admin.services.index') }}"
                               class="admin-btn admin-btn--outline admin-btn--full">
                                Отмена
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
