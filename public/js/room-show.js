document.addEventListener('DOMContentLoaded', function () {
    const ratingInputs = document.querySelectorAll('.reviews__rating-star input');

    ratingInputs.forEach(function (star) {
        star.addEventListener('change', function () {
            const value = Number.parseInt(this.value, 10);
            const stars = this.closest('.reviews__rating-stars').querySelectorAll('.reviews__rating-star label');

            stars.forEach(function (starLabel, index) {
                const starValue = 5 - index;
                starLabel.style.color = starValue <= value ? '#ffc107' : '#ddd';
            });
        });
    });

    const gallery = document.querySelector('[data-room-gallery]');
    const track = gallery ? gallery.querySelector('.room-show__carousel-track') : null;
    const thumbs = Array.from(document.querySelectorAll('[data-room-thumb]'));
    const slides = Array.from(document.querySelectorAll('[data-room-slide]'));
    const prevButton = document.querySelector('[data-room-prev]');
    const nextButton = document.querySelector('[data-room-next]');

    if (!gallery || !track || slides.length === 0) {
        return;
    }

    let currentIndex = slides.findIndex(function (slide) {
        return slide.classList.contains('is-active');
    });

    if (currentIndex < 0) {
        currentIndex = 0;
    }

    const setActiveThumb = function (index) {
        thumbs.forEach(function (thumb, thumbIndex) {
            const isActive = thumbIndex === index;
            thumb.classList.toggle('is-active', isActive);
            thumb.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    };

    const setActiveSlide = function (index) {
        currentIndex = (index + slides.length) % slides.length;

        slides.forEach(function (slide, slideIndex) {
            slide.classList.toggle('is-active', slideIndex === currentIndex);
        });

        track.style.transform = 'translateX(-' + currentIndex * 100 + '%)';
        setActiveThumb(currentIndex);
    };

    if (prevButton) {
        prevButton.addEventListener('click', function () {
            setActiveSlide(currentIndex - 1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            setActiveSlide(currentIndex + 1);
        });
    }

    thumbs.forEach(function (thumb, index) {
        thumb.addEventListener('click', function () {
            setActiveSlide(index);
        });
    });

    let touchStartX = 0;
    let touchEndX = 0;

    gallery.addEventListener('touchstart', function (event) {
        touchStartX = event.changedTouches[0].clientX;
    }, { passive: true });

    gallery.addEventListener('touchend', function (event) {
        touchEndX = event.changedTouches[0].clientX;

        if (Math.abs(touchStartX - touchEndX) < 40) {
            return;
        }

        if (touchStartX > touchEndX) {
            setActiveSlide(currentIndex + 1);
        } else {
            setActiveSlide(currentIndex - 1);
        }
    }, { passive: true });

    setActiveSlide(currentIndex);
});
