document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById('descGalleryLightbox');
    const lightboxImage = document.getElementById('descGalleryLightboxImage');
    const lightboxCaption = document.getElementById('descGalleryLightboxCaption');
    const lightboxClose = lightbox ? lightbox.querySelector('.desc-gallery-lightbox__close') : null;
    const triggers = document.querySelectorAll('[data-desc-gallery-trigger]');
    const closeTriggers = document.querySelectorAll('[data-desc-gallery-close]');
    let lastActiveTrigger = null;
    let closeTimer = null;

    if (!lightbox || !lightboxImage || !lightboxCaption || !lightboxClose || !triggers.length) {
        return;
    }

    const openLightbox = function (trigger) {
        if (closeTimer) {
            window.clearTimeout(closeTimer);
            closeTimer = null;
        }

        lastActiveTrigger = trigger;
        lightboxImage.src = trigger.dataset.descGallerySrc || '';
        lightboxImage.alt = trigger.dataset.descGalleryAlt || '';
        lightboxCaption.textContent = trigger.dataset.descGalleryAlt || '';
        lightbox.hidden = false;
        document.body.classList.add('desc-gallery-lightbox-open');

        window.requestAnimationFrame(function () {
            lightbox.classList.add('is-open');
            lightboxClose.focus();
        });
    };

    const closeLightbox = function () {
        if (lightbox.hidden) {
            return;
        }

        lightbox.classList.remove('is-open');
        document.body.classList.remove('desc-gallery-lightbox-open');

        closeTimer = window.setTimeout(function () {
            lightbox.hidden = true;
            lightboxImage.src = '';
            lightboxImage.alt = '';
            lightboxCaption.textContent = '';
            closeTimer = null;
        }, 180);

        if (lastActiveTrigger) {
            lastActiveTrigger.focus();
        }
    };

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            openLightbox(trigger);
        });
    });

    closeTriggers.forEach(function (trigger) {
        trigger.addEventListener('click', closeLightbox);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeLightbox();
        }
    });
});
