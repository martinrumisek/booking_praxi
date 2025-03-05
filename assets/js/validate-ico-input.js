    const icoPattern = /^\d{8}$/;  // Vzor pro IČO (8 číslic)
    const icoInputs = document.querySelectorAll('.ico');  // Vybere všechny inputy s třídou 'ico'

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (event) => {
                let isValid = true;

                icoInputs.forEach(input => {
                    const tooltipIco = bootstrap.Tooltip.getInstance(input) || new bootstrap.Tooltip(input, {
                        html: true,
                        title: 'IČO musí mít 8 číslic.',
                        trigger: 'manual',
                    });

                    if (!icoPattern.test(input.value.trim())) {
                        input.classList.add('invalid-input');
                        tooltipIco.show();
                        isValid = false;
                    } else {
                        input.classList.remove('invalid-input');
                        tooltipIco.hide();
                    }
                });

                // Pokud je neplatné IČO, zastavíme odeslání formuláře
                if (!isValid) {
                    event.preventDefault();
                }
            });

            // Validace IČO při zadávání
            icoInputs.forEach(input => {
                const tooltipIco = new bootstrap.Tooltip(input, {
                    html: true,
                    title: 'IČO musí mít 8 číslic.',
                    trigger: 'manual',
                });

                input.addEventListener('input', () => {
                    if (!icoPattern.test(input.value.trim())) {
                        input.classList.add('invalid-input');
                        tooltipIco.show();
                    } else {
                        input.classList.remove('invalid-input');
                        tooltipIco.hide();
                    }
                });
            });
        });
    });