document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', (event) => {
            let isValid = true;
            const emailPattern = /^[a-žA-Ž0-9._-]+@[a-žA-Ž0-9.-]+\.[a-žA-Ž]{2,}$/;
            form.querySelectorAll('.mail').forEach(mailInput => {
                const tooltipEmailPerson = new bootstrap.Tooltip(mailInput, {
                    html: true,
                    title: 'E-mail musí být ve správném formátu!',
                    trigger: 'manual',
                });
                const mail = mailInput.value;
                if (!emailPattern.test(mail)) {
                    mailInput.classList.add('invalid-input');
                    tooltipEmailPerson.show();
                    isValid = false;
                } else {
                    mailInput.classList.remove('invalid-input');
                    tooltipEmailPerson.hide();
                }
            });
            if (!isValid) {
                event.preventDefault();
            }
        });
        form.querySelectorAll('.mail').forEach(mailInput => {
            const tooltipEmailPerson = new bootstrap.Tooltip(mailInput, {
                html: true,
                title: 'E-mail musí být ve správném formátu!',
                trigger: 'manual',
            });
            mailInput.addEventListener('input', () => {
                const emailPattern = /^[a-žA-Ž0-9._-]+@[a-žA-Ž0-9.-]+\.[a-žA-Ž]{2,}$/;
                const mail = mailInput.value;
                if (!emailPattern.test(mail)) {
                    mailInput.classList.add('invalid-input');
                    tooltipEmailPerson.show();
                } else {
                    mailInput.classList.remove('invalid-input');
                    tooltipEmailPerson.hide();
                }
            });
        });
    });
});
