document.addEventListener('DOMContentLoaded', function () {
    const imageSelector = '.js-skeleton-image';

    function ensureTransition(image) {
        const computedTransition = window.getComputedStyle(image).transition;
        const revealTransition = 'opacity 0.35s ease, filter 0.35s ease';

        if (image.dataset.skeletonTransitionBound === 'true') {
            return;
        }

        if (!computedTransition || computedTransition === 'all 0s ease 0s') {
            image.style.transition = revealTransition;
        } else if (!computedTransition.includes('opacity')) {
            image.style.transition = computedTransition + ', ' + revealTransition;
        }

        image.dataset.skeletonTransitionBound = 'true';
    }

    function revealImage(image) {
        ensureTransition(image);
        image.classList.add('is-loaded');
        image.classList.remove('is-loading');
    }

    function bindImage(image) {
        if (!(image instanceof HTMLImageElement) || image.dataset.skeletonBound === 'true') {
            return;
        }

        image.dataset.skeletonBound = 'true';
        image.classList.add('is-loading');
        ensureTransition(image);

        if (image.complete) {
            window.requestAnimationFrame(function () {
                revealImage(image);
            });
            return;
        }

        image.addEventListener('load', function () {
            revealImage(image);
        }, { once: true });

        image.addEventListener('error', function () {
            revealImage(image);
        }, { once: true });
    }

    function bindWithin(root) {
        if (!root) {
            return;
        }

        if (root.matches && root.matches(imageSelector)) {
            bindImage(root);
        }

        if (root.querySelectorAll) {
            root.querySelectorAll(imageSelector).forEach(bindImage);
        }
    }

    bindWithin(document);

    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            mutation.addedNodes.forEach(function (node) {
                bindWithin(node);
            });
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });
});
