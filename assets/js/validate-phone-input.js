document.addEventListener('DOMContentLoaded', () => {
    const phoneInputs = document.querySelectorAll('.phone-input');
    phoneInputs.forEach(phoneInput => {
        phoneInput.setAttribute('data-bs-toggle', 'tooltip');
        phoneInput.setAttribute('data-bs-placement', 'top');
        phoneInput.setAttribute('title', 'Neplatný formát čísla');
        let tooltip = new bootstrap.Tooltip(phoneInput, { trigger: 'manual' });
        phoneInput.addEventListener('input', () => {
            let value = phoneInput.value.replace(/[^+\d]/g, '');
            if (value.startsWith('420') || value.startsWith('421')) {
                value = '+' + value;
            }
            if (value.startsWith('+420') || value.startsWith('+421')) {
                value = value.slice(0, 4) + ' ' + value.slice(4, 7) + ' ' + value.slice(7, 10) + ' ' + value.slice(10, 13);
            } else {
                value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6, 9);
            }
            phoneInput.value = value.trim();
            const phonePattern = /^(?:\+420|\+421)? ?\d{3} ?\d{3} ?\d{3}$/;
            if (phonePattern.test(phoneInput.value)) {
                phoneInput.classList.remove('invalid-input');
                tooltip.hide();
            } else {
                phoneInput.classList.add('invalid-input');
                tooltip.show();
            }
        });
    });
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', (event) => {
            const invalidInputs = form.querySelectorAll('.invalid-input');
            if (invalidInputs.length > 0) {
                event.preventDefault();
                invalidInputs.forEach(input => {
                    let tooltip = bootstrap.Tooltip.getInstance(input);
                    if (tooltip) tooltip.show();
                });
                return false;
            }
        });
    });
});
