document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', (event) => {
            let isValid = true;
            form.querySelectorAll('.empty-input').forEach(input => {
                const tooltip = bootstrap.Tooltip.getInstance(input) || new bootstrap.Tooltip(input, {
                    html: true,
                    title: 'Toto pole je povinné!',
                    trigger: 'manual',
                });

                if (!input.value.trim()) {
                    input.classList.add('invalid-input');
                    tooltip.show();
                    isValid = false;
                } else {
                    input.classList.remove('invalid-input');
                    tooltip.hide();
                }
            });
            if (!isValid) {
                event.preventDefault();
            }
        });
        form.querySelectorAll('.empty-input').forEach(input => {
            const tooltip = new bootstrap.Tooltip(input, {
                html: true,
                title: 'Toto pole je povinné!',
                trigger: 'manual',
            });
            input.addEventListener('input', () => {
                if (!input.value.trim()) {
                    input.classList.add('invalid-input');
                    tooltip.show();
                } else {
                    input.classList.remove('invalid-input');
                    tooltip.hide();
                }
            });
        });
    });
});
