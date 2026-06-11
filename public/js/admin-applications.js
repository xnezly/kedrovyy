document.addEventListener('DOMContentLoaded', function () {
    if (!window.bootstrap || typeof window.bootstrap.Tooltip !== 'function') {
        return;
    }

    const tooltipTriggers = Array.from(document.querySelectorAll('[title]'));

    tooltipTriggers.forEach(function (tooltipTrigger) {
        new window.bootstrap.Tooltip(tooltipTrigger);
    });
});
