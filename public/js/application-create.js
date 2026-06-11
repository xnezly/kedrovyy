document.addEventListener('DOMContentLoaded', function () {
    const bookingPage = document.querySelector('.booking-page');

    if (!bookingPage) {
        return;
    }

    const roomPrice = Number(bookingPage.dataset.roomPrice || 0);
    const ageInput = document.getElementById('age');
    const guestsInput = document.getElementById('number_of_guests');
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const nightsInput = document.getElementById('nights');
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');

    const summaryGuests = document.getElementById('bookingSummaryGuests');
    const summaryDates = document.getElementById('bookingSummaryDates');
    const summaryNights = document.getElementById('bookingSummaryNights');
    const summaryServices = document.getElementById('bookingSummaryServices');
    const summaryServicesList = document.getElementById('bookingSummaryServicesList');
    const roomTotal = document.getElementById('bookingRoomTotal');
    const servicesRow = document.getElementById('bookingServicesRow');
    const servicesTotal = document.getElementById('bookingServicesTotal');
    const grandTotal = document.getElementById('bookingGrandTotal');
    const grandTotalMobile = document.getElementById('bookingGrandTotalMobile');

    if (!guestsInput || !checkInInput || !checkOutInput || !nightsInput || !summaryGuests || !summaryDates ||
        !summaryNights || !summaryServices || !summaryServicesList || !roomTotal || !servicesRow ||
        !servicesTotal || !grandTotal) {
        return;
    }

    function formatMoney(value) {
        return new Intl.NumberFormat('ru-RU').format(value) + ' ₽';
    }

    function formatDate(value) {
        if (!value) {
            return '';
        }

        const parts = value.split('-');
        return [parts[2], parts[1], parts[0]].join('.');
    }

    function getGuestsLabel(guests) {
        if (guests === 1) {
            return 'гость';
        }

        if (guests >= 2 && guests <= 4) {
            return 'гостя';
        }

        return 'гостей';
    }

    function calculateNights() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;

        checkOutInput.min = checkIn || '';

        if (!checkIn || !checkOut) {
            nightsInput.value = 0;
            return 0;
        }

        const start = new Date(checkIn);
        const end = new Date(checkOut);
        const diff = end.getTime() - start.getTime();

        if (diff <= 0) {
            nightsInput.value = 0;
            return 0;
        }

        const nights = Math.ceil(diff / (1000 * 60 * 60 * 24));
        nightsInput.value = nights;
        return nights;
    }

    function getSelectedServices() {
        const selectedServices = [];

        serviceCheckboxes.forEach(function (checkbox) {
            const card = checkbox.closest('.booking-services__card');

            if (checkbox.checked) {
                selectedServices.push({
                    name: checkbox.dataset.name || 'Дополнительная услуга',
                    price: Number(checkbox.dataset.price || 0),
                });
                if (card) {
                    card.classList.add('booking-services__card--selected');
                }
            } else if (card) {
                card.classList.remove('booking-services__card--selected');
            }
        });

        return selectedServices;
    }

    function renderSelectedServices(selectedServices) {
        summaryServicesList.replaceChildren();

        if (selectedServices.length === 0) {
            summaryServices.hidden = true;
            return;
        }

        selectedServices.forEach(function (service) {
            const item = document.createElement('div');
            item.className = 'booking-summary__services-item';

            const name = document.createElement('span');
            name.className = 'booking-summary__services-name';
            name.textContent = service.name;

            const price = document.createElement('strong');
            price.className = 'booking-summary__services-price';
            price.textContent = formatMoney(service.price);

            item.append(name, price);
            summaryServicesList.append(item);
        });

        summaryServices.hidden = false;
    }

    function updateSummary() {
        const guests = Math.max(Number.parseInt(guestsInput.value || '1', 10), 1);
        const nights = calculateNights();
        const selectedServices = getSelectedServices();
        const servicesSum = selectedServices.reduce(function (total, service) {
            return total + service.price;
        }, 0);
        const roomSum = nights > 0 ? roomPrice * nights : 0;
        const total = roomSum + servicesSum;

        summaryGuests.textContent = guests + ' ' + getGuestsLabel(guests);
        summaryNights.textContent = nights > 0 ? String(nights) : '0';

        if (checkInInput.value && checkOutInput.value) {
            summaryDates.textContent = formatDate(checkInInput.value) + ' — ' + formatDate(checkOutInput.value);
        } else {
            summaryDates.textContent = 'Выберите даты';
        }

        renderSelectedServices(selectedServices);
        roomTotal.textContent = formatMoney(roomSum);
        grandTotal.textContent = formatMoney(total);

        if (grandTotalMobile) {
            grandTotalMobile.textContent = formatMoney(total);
        }

        if (servicesSum > 0) {
            servicesRow.hidden = false;
            servicesTotal.textContent = formatMoney(servicesSum);
        } else {
            servicesRow.hidden = true;
            servicesTotal.textContent = formatMoney(0);
        }
    }

    if (ageInput) {
        ageInput.addEventListener('keydown', function (event) {
            if (['-', '+', 'e', 'E'].includes(event.key)) {
                event.preventDefault();
            }
        });

        ageInput.addEventListener('input', function () {
            if (ageInput.value === '') {
                return;
            }

            const normalizedAge = Math.min(Math.max(Number.parseInt(ageInput.value, 10) || 0, 0), 120);
            ageInput.value = String(normalizedAge);
        });
    }

    guestsInput.addEventListener('input', updateSummary);
    checkInInput.addEventListener('change', updateSummary);
    checkOutInput.addEventListener('change', updateSummary);

    serviceCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', updateSummary);
    });

    updateSummary();
});
