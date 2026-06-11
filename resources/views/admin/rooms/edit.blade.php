@extends('admin-theme')
@section('title', $room->name . ' | Изменить номер')
@section('content')
    <div class="admin-room-form">

        {{-- Заголовок --}}
        <div class="admin-room-form__header">
            <h1 class="admin-room-form__title">Редактировать номер</h1>
            <a href="{{ route('admin.rooms.index') }}" class="admin-room-form__back-btn">
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
            action="{{ route('admin.rooms.update', $room) }}"
            method="post"
            enctype="multipart/form-data"
            class="admin-room-form__form"
        >
            @csrf
            @method('PATCH')

            <div class="admin-room-form__grid">
                {{-- Левая колонка --}}
                <div class="admin-room-form__main">

                    {{-- Основная информация --}}
                    <div class="admin-card admin-card--form">
                        <h2 class="admin-card__subtitle">Основная информация</h2>

                        <div class="admin-form__field">
                            <label for="name" class="admin-form__label">Название номера *</label>
                            <input
                                type="text"
                                class="admin-form__input @error('name') admin-form__input--invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $room->name) }}"
                                required
                            >
                            @error('name')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form__field">
                            <label for="description" class="admin-form__label">Описание</label>
                            <textarea
                                class="admin-form__textarea admin-form__textarea--medium @error('description') admin-form__input--invalid @enderror"
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Описание номера">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form__field">
                            <label for="price" class="admin-form__label">Цена за ночь (руб) *</label>
                            <input
                                type="number"
                                class="admin-form__input @error('price') admin-form__input--invalid @enderror"
                                id="price"
                                name="price"
                                value="{{ old('price', $room->price) }}"
                                min="0"
                                required
                            >
                            @error('price')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Удобства --}}
                    <div class="admin-card admin-card--form">
                        <h2 class="admin-card__subtitle">Удобства</h2>

                        <div class="admin-amenities-grid">
                            @foreach($services as $service)
                                <div class="admin-amenities__item">
                                    <label class="admin-checkbox-label" for="service_{{ $service->id }}">
                                        <input
                                            class="admin-checkbox"
                                            type="checkbox"
                                            name="services[]"
                                            value="{{ $service->id }}"
                                            id="service_{{ $service->id }}"
                                            @checked(in_array($service->id, old('services', $room->services->pluck('id')->toArray())))
                                        >
                                        <span class="admin-checkbox__text">{{ $service->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Правая колонка (сайдбар) --}}
                <div class="admin-room-form__sidebar">
                    <div class="admin-card admin-card--sidebar">
                        <h2 class="admin-card__subtitle">Фото номера</h2>

                        @if($room->images->isNotEmpty())
                            <div class="admin-form__field">
                                <label class="admin-form__label">Текущее фото</label>
                                <img
                                    src="{{ $room->image_url }}"
                                    alt="{{ $room->name }}"
                                    class="admin-image-preview__img admin-image-preview__img--current"
                                >
                            </div>
                        @endif

                        <div class="admin-form__field">
                            <label for="images" class="admin-form__label">Загрузить новое фото</label>
                            <input
                                type="file"
                                class="admin-form__input-file @error('images') admin-form__input--invalid @enderror"
                                id="images"
                                name="images[]"
                                accept="image/*"
                                multiple
                            >
                            @error('images')
                            <span class="admin-form__error">{{ $message }}</span>
                            @enderror
                            @if($errors->has('images.*'))
                                <span class="admin-form__error">{{ $errors->first('images.*') }}</span>
                            @endif
                            <small class="admin-form__hint">JPG, JPEG, PNG, WEBP. До 15 фото, до 10 МБ каждое, общий размер до 48 МБ.</small>
                            <div id="imageUploadStatus" class="admin-upload-status">
                                Можно заменить фотографии номера сразу пакетом. Если файлов много, загружайте их партиями.
                            </div>
                        </div>

                        <div id="imagePreview" class="admin-image-preview" style="display: none;">
                            <img src="" alt="Preview" class="admin-image-preview__img" id="previewImg">
                        </div>

                        <div class="admin-room-form__actions">
                            <button type="submit" class="admin-btn admin-btn--success admin-btn--full">
                                Сохранить изменения
                            </button>

                            <a
                                href="{{ route('admin.rooms.index') }}"
                                class="admin-btn admin-btn--outline admin-btn--full"
                            >
                                Отмена
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function setupRoomImageUpload(inputId, previewId, previewImgId, statusId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const previewImg = document.getElementById(previewImgId);
            const status = document.getElementById(statusId);

            if (!input || !preview || !previewImg || !status) {
                return;
            }

            const limits = {
                maxFiles: 15,
                maxFileSize: 10 * 1024 * 1024,
                maxTotalSize: 48 * 1024 * 1024,
            };

            function formatBytes(bytes) {
                if (bytes < 1024 * 1024) {
                    return Math.round(bytes / 1024) + ' КБ';
                }

                return (bytes / (1024 * 1024)).toFixed(1).replace('.', ',') + ' МБ';
            }

            function setStatus(message, type) {
                status.textContent = message;
                status.className = 'admin-upload-status admin-upload-status--' + type;
            }

            function validateFiles(files) {
                if (!files.length) {
                    return null;
                }

                if (files.length > limits.maxFiles) {
                    return 'Можно выбрать не более 15 фотографий за один раз.';
                }

                let totalSize = 0;

                for (const file of files) {
                    totalSize += file.size;

                    if (!file.type.startsWith('image/')) {
                        return 'Все выбранные файлы должны быть изображениями.';
                    }

                    if (file.size > limits.maxFileSize) {
                        return 'Файл "' + file.name + '" больше 10 МБ. Уменьшите его размер.';
                    }
                }

                if (totalSize > limits.maxTotalSize) {
                    return 'Общий размер выбранных файлов слишком большой. Загружайте примерно до 48 МБ за один раз.';
                }

                return null;
            }

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (event) {
                        previewImg.src = event.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.style.display = 'none';
                    previewImg.src = '';
                }
            }

            function handleFiles() {
                const files = Array.from(input.files || []);
                const error = validateFiles(files);

                if (error) {
                    input.value = '';
                    previewImage(input);
                    setStatus(error, 'error');
                    return false;
                }

                previewImage(input);

                if (!files.length) {
                    setStatus('Можно заменить фотографии номера сразу пакетом. Если файлов много, загружайте их партиями.', 'info');
                    return true;
                }

                const totalSize = files.reduce((sum, file) => sum + file.size, 0);
                setStatus('Выбрано ' + files.length + ' фото. Общий размер: ' + formatBytes(totalSize) + '.', 'success');

                return true;
            }

            input.addEventListener('change', handleFiles);

            input.form?.addEventListener('submit', function (event) {
                if (!handleFiles()) {
                    event.preventDefault();
                    input.focus();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            setupRoomImageUpload('images', 'imagePreview', 'previewImg', 'imageUploadStatus');
        });
    </script>
@endsection
