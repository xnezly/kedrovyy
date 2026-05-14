    document.addEventListener('DOMContentLoaded', function() {
    const burgerBtn = document.getElementById('burgerBtn');
    const mainNav = document.getElementById('mainNav');

    if (burgerBtn && mainNav) {
    burgerBtn.addEventListener('click', function() {
    this.classList.toggle('active');
    mainNav.classList.toggle('open');

    // Блокируем скролл страницы при открытом меню
    document.body.style.overflow = mainNav.classList.contains('open') ? 'hidden' : '';
});
}
});
