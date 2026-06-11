document.addEventListener('DOMContentLoaded', function () {
    const promoToast = document.getElementById('promoToast');
    const promoToastClose = document.getElementById('promoToastClose');
    const promoToastLabel = promoToast ? promoToast.querySelector('.promo-toast__label') : null;
    const promoToastText = promoToast ? promoToast.querySelector('.promo-toast__text') : null;
    const promoShortLabel = '\u0421\u043f\u0435\u0446\u043f\u0440\u0435\u0434\u043b\u043e\u0436\u0435\u043d\u0438\u0435';
    const promoCloseLabel = '\u0417\u0430\u043a\u0440\u044b\u0442\u044c \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u0435';

    if (promoToastLabel) {
        promoToastLabel.textContent = promoShortLabel;
    }

    if (promoToastText) {
        promoToastText.textContent = '\u0421\u043a\u0438\u0434\u043a\u0430 10% \u043d\u0430 \u0432\u0441\u0435 \u043d\u043e\u043c\u0435\u0440\u0430 \u043f\u0440\u0438 \u0431\u0440\u043e\u043d\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0438 \u043d\u0430 3 \u043d\u043e\u0447\u0438!';
    }

    if (!promoToast || !promoToastClose) {
        return;
    }

    promoToastClose.setAttribute('aria-label', promoCloseLabel);

    const storageKey = 'kedrovyy_promo_toast_closed';

    try {
        if (window.sessionStorage.getItem(storageKey) === '1') {
            promoToast.remove();
            return;
        }
    } catch (error) {
    }

    window.requestAnimationFrame(function () {
        promoToast.classList.add('is-visible');
    });

    promoToastClose.addEventListener('click', function () {
        promoToast.classList.remove('is-visible');

        try {
            window.sessionStorage.setItem(storageKey, '1');
        } catch (error) {
        }

        window.setTimeout(function () {
            promoToast.remove();
        }, 280);
    });
});
