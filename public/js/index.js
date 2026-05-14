let currentIndex = 0;
const items = document.querySelectorAll('.carousel-item');
const totalItems = items.length;

function showItem(index) {
    const offset = -index * 100;
    document.querySelector('.carousel-inner').style.transform = `translateX(${offset}%)`;
}

document.getElementById('next').addEventListener('click', function() {
    currentIndex = (currentIndex + 1) % totalItems;
    showItem(currentIndex);
});

document.getElementById('prev').addEventListener('click', function() {
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    showItem(currentIndex);
});

setInterval(function() {
    currentIndex = (currentIndex + 1) % totalItems;
    showItem(currentIndex);
}, 5000);


function toggleFAQ(index) {
    const items = document.querySelectorAll('.faq-item');
    const item = items[index];

    // Закрываем все, если хотим только один активный
    items.forEach((i, idx) => {
        if (idx !== index) {
            i.classList.remove('active');
        }
    });

    // Переключаем текущий
    item.classList.toggle('active');
}
