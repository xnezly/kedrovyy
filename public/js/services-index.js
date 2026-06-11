document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('serviceOrderModal');
    const serviceIdField = document.getElementById('modalServiceId');
    const serviceNameField = document.getElementById('modalServiceName');
    const servicePriceField = document.getElementById('modalServicePrice');

    if (!modal || !serviceIdField || !serviceNameField || !servicePriceField) {
        return;
    }

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        if (!button) {
            return;
        }

        serviceIdField.value = button.getAttribute('data-service-id') || '';
        serviceNameField.textContent = button.getAttribute('data-service-name') || '';
        servicePriceField.textContent = new Intl.NumberFormat('ru-RU').format(
            Number(button.getAttribute('data-service-price') || 0)
        ) + ' ₽';
    });
});
