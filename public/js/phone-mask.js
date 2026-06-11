(function () {
    function formatPhone(value) {
        let digits = (value || '').replace(/\D+/g, '');

        if (!digits) {
            return '';
        }

        if (digits.charAt(0) === '8') {
            digits = '7' + digits.slice(1);
        } else if (digits.charAt(0) !== '7') {
            digits = '7' + digits;
        }

        digits = digits.slice(0, 11);

        let result = '+7';

        if (digits.length > 1) {
            result += ' (' + digits.slice(1, 4);
        }

        if (digits.length >= 4) {
            result += ')';
        }

        if (digits.length > 4) {
            result += ' ' + digits.slice(4, 7);
        }

        if (digits.length > 7) {
            result += '-' + digits.slice(7, 9);
        }

        if (digits.length > 9) {
            result += '-' + digits.slice(9, 11);
        }

        return result;
    }

    function bindPhoneMask(input) {
        if (!input || input.dataset.phoneMaskReady === 'true') {
            return;
        }

        input.dataset.phoneMaskReady = 'true';
        input.setAttribute('inputmode', 'tel');
        input.setAttribute('maxlength', '18');
        input.autocomplete = input.autocomplete || 'tel';

        if (input.value) {
            input.value = formatPhone(input.value);
        }

        input.addEventListener('input', function () {
            input.value = formatPhone(input.value);
        });

        input.addEventListener('blur', function () {
            input.value = formatPhone(input.value);
        });
    }

    function initPhoneMasks() {
        const inputs = Array.from(document.querySelectorAll('[data-phone-mask]'));
        const phoneById = document.getElementById('phone');

        if (phoneById && !inputs.includes(phoneById)) {
            inputs.push(phoneById);
        }

        inputs.forEach(bindPhoneMask);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPhoneMasks);
    } else {
        initPhoneMasks();
    }
})();
