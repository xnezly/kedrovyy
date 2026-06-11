document.addEventListener('DOMContentLoaded', function () {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');

    if (!checkInInput || !checkOutInput) {
        return;
    }

    const syncCheckOut = function () {
        if (!checkInInput.value) {
            return;
        }

        const nextDay = new Date(checkInInput.value + 'T00:00:00');
        nextDay.setDate(nextDay.getDate() + 1);

        const minCheckOut = nextDay.toISOString().split('T')[0];
        checkOutInput.min = minCheckOut;

        if (!checkOutInput.value || checkOutInput.value <= checkInInput.value) {
            checkOutInput.value = minCheckOut;
        }
    };

    checkInInput.addEventListener('change', syncCheckOut);
    syncCheckOut();
});
