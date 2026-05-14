const phoneMask = {
    mask: '+{7} (000) 000-00-00',
    prepare: str => {
        if (str.length > 10 && str.startsWith('8')) {
            return str.substring(1);
        }

        return str;
    },
};

const phone = document.getElementById('phone');
IMask(phone, phoneMask);
