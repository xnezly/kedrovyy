document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('images');
    const preview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImg');
    const status = document.getElementById('imageUploadStatus');

    if (!input || !preview || !previewImage || !status) {
        return;
    }

    const limits = {
        maxFiles: 15,
        maxFileSize: 10 * 1024 * 1024,
        maxTotalSize: 48 * 1024 * 1024,
    };
    const emptyMessage = status.textContent.trim();

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

    function updatePreview() {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (event) {
                previewImage.src = event.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
            previewImage.src = '';
        }
    }

    function handleFiles() {
        const files = Array.from(input.files || []);
        const error = validateFiles(files);

        if (error) {
            input.value = '';
            updatePreview();
            setStatus(error, 'error');
            return false;
        }

        updatePreview();

        if (!files.length) {
            setStatus(emptyMessage, 'info');
            return true;
        }

        const totalSize = files.reduce(function (sum, file) {
            return sum + file.size;
        }, 0);

        setStatus('Выбрано ' + files.length + ' фото. Общий размер: ' + formatBytes(totalSize) + '.', 'success');
        return true;
    }

    input.addEventListener('change', handleFiles);

    if (input.form) {
        input.form.addEventListener('submit', function (event) {
            if (!handleFiles()) {
                event.preventDefault();
                input.focus();
            }
        });
    }
});
