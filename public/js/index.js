document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carousel');
    const track = carousel ? carousel.querySelector('.carousel-inner') : null;
    const items = carousel ? Array.from(carousel.querySelectorAll('.carousel-item')) : [];
    const nextButton = document.getElementById('next');
    const prevButton = document.getElementById('prev');
    let currentIndex = 0;
    let carouselTimer = null;

    function showItem(index) {
        if (!track || !items.length) {
            return;
        }

        currentIndex = (index + items.length) % items.length;
        track.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';

        items.forEach(function (item, itemIndex) {
            item.classList.toggle('active', itemIndex === currentIndex);
        });
    }

    function startCarousel() {
        if (items.length < 2) {
            return;
        }

        stopCarousel();
        carouselTimer = window.setInterval(function () {
            showItem(currentIndex + 1);
        }, 5000);
    }

    function stopCarousel() {
        if (carouselTimer) {
            window.clearInterval(carouselTimer);
            carouselTimer = null;
        }
    }

    if (track && nextButton && prevButton && items.length) {
        nextButton.addEventListener('click', function () {
            showItem(currentIndex + 1);
            startCarousel();
        });

        prevButton.addEventListener('click', function () {
            showItem(currentIndex - 1);
            startCarousel();
        });

        carousel.addEventListener('mouseenter', stopCarousel);
        carousel.addEventListener('mouseleave', startCarousel);

        showItem(0);
        startCarousel();
    }

    const faqItems = Array.from(document.querySelectorAll('.faq-item'));

    function closeFaqItem(item) {
        const button = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const inner = item.querySelector('.faq-answer__inner');

        if (!button || !answer || !inner) {
            return;
        }

        button.setAttribute('aria-expanded', 'false');
        item.classList.remove('is-open');
        answer.style.maxHeight = answer.scrollHeight + 'px';

        window.requestAnimationFrame(function () {
            answer.style.maxHeight = '0px';
            answer.style.opacity = '0';
        });

        const onTransitionEnd = function (event) {
            if (event.propertyName !== 'max-height') {
                return;
            }

            answer.hidden = true;
            answer.removeEventListener('transitionend', onTransitionEnd);
        };

        answer.addEventListener('transitionend', onTransitionEnd);
    }

    function openFaqItem(item) {
        const button = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const inner = item.querySelector('.faq-answer__inner');

        if (!button || !answer || !inner) {
            return;
        }

        answer.hidden = false;
        item.classList.add('is-open');
        button.setAttribute('aria-expanded', 'true');
        answer.style.opacity = '1';
        answer.style.maxHeight = inner.scrollHeight + 'px';
    }

    if (faqItems.length) {
        faqItems.forEach(function (item) {
            const button = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            if (!button || !answer) {
                return;
            }

            answer.hidden = true;
            answer.style.maxHeight = '0px';
            answer.style.opacity = '0';
            button.setAttribute('aria-expanded', 'false');

            button.addEventListener('click', function () {
                const isOpen = item.classList.contains('is-open');

                faqItems.forEach(function (faqItem) {
                    if (faqItem !== item && faqItem.classList.contains('is-open')) {
                        closeFaqItem(faqItem);
                    }
                });

                if (isOpen) {
                    closeFaqItem(item);
                } else {
                    openFaqItem(item);
                }
            });
        });

        window.addEventListener('resize', function () {
            faqItems.forEach(function (item) {
                if (!item.classList.contains('is-open')) {
                    return;
                }

                const answer = item.querySelector('.faq-answer');
                const inner = item.querySelector('.faq-answer__inner');

                if (answer && inner) {
                    answer.style.maxHeight = inner.scrollHeight + 'px';
                }
            });
        });
    }
});
