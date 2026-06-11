(function () {
    try {
        var transitionDirection = window.sessionStorage.getItem('kedrovyy_page_transition');

        if (transitionDirection === 'forward' || transitionDirection === 'back') {
            document.documentElement.classList.add(
                'page-transition-entering',
                'page-transition-entering--' + transitionDirection
            );
        }
    } catch (error) {
    }
})();
