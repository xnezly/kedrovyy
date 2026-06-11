document.addEventListener('DOMContentLoaded', function () {
    const root = document.documentElement;
    const body = document.body;
    const layer = document.getElementById('pageTransitionLayer');
    const storageKey = 'kedrovyy_page_transition';
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!layer) {
        return;
    }

    function clearTransitionState() {
        root.classList.remove(
            'page-transition-entering',
            'page-transition-entering--forward',
            'page-transition-entering--back',
            'page-transition-active'
        );

        body.classList.remove(
            'page-transition-out',
            'page-transition-out--forward',
            'page-transition-out--back'
        );

        try {
            window.sessionStorage.removeItem(storageKey);
        } catch (error) {
        }
    }

    if (root.classList.contains('page-transition-entering')) {
        if (reduceMotion) {
            clearTransitionState();
        } else {
            root.classList.add('page-transition-active');

            window.setTimeout(function () {
                clearTransitionState();
            }, 620);
        }
    }

    document.querySelectorAll('[data-page-transition]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            if (
                reduceMotion ||
                event.defaultPrevented ||
                event.button !== 0 ||
                event.metaKey ||
                event.ctrlKey ||
                event.shiftKey ||
                event.altKey ||
                link.target === '_blank'
            ) {
                return;
            }

            const href = link.href;
            const direction = link.dataset.pageTransition;

            if (!href || (direction !== 'forward' && direction !== 'back')) {
                return;
            }

            const url = new URL(href, window.location.href);

            if (url.origin !== window.location.origin) {
                return;
            }

            event.preventDefault();

            link.classList.add('is-transitioning');
            body.classList.add('page-transition-out', 'page-transition-out--' + direction);
            root.classList.add('page-transition-active');

            try {
                window.sessionStorage.setItem(storageKey, direction);
            } catch (error) {
            }

            window.setTimeout(function () {
                window.location.href = href;
            }, 320);
        });
    });

    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            clearTransitionState();
        }
    });
});
