document.addEventListener('DOMContentLoaded', function () {
    var forms = document.querySelectorAll('form[novalidate]');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            var errors = collectErrors(form);

            if (errors.length > 0) {
                event.preventDefault();
                showErrors(form, errors);
            }
        });
    });

    function collectErrors(form) {
        var errors = [];

        form.querySelectorAll('[required]').forEach(function (field) {
            var value = field.value.trim();
            if (value === '') {
                errors.push(labelFor(field) + ' is required.');
                markInvalid(field);
            } else {
                markValid(field);
            }
        });

        var emailField = form.querySelector('input[type="email"]');
        if (emailField && emailField.value.trim() !== '') {
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailField.value.trim())) {
                errors.push('Please enter a valid email address.');
                markInvalid(emailField);
            }
        }

        var passwordField = form.querySelector('input[name="password"][minlength]');
        if (passwordField && passwordField.value !== '') {
            var minLength = parseInt(passwordField.getAttribute('minlength'), 10);
            if (passwordField.value.length < minLength) {
                errors.push('Password must be at least ' + minLength + ' characters long.');
                markInvalid(passwordField);
            }
        }

        var confirmField = form.querySelector('input[name="confirm_password"]');
        if (passwordField && confirmField && confirmField.value !== '') {
            if (passwordField.value !== confirmField.value) {
                errors.push('Passwords do not match.');
                markInvalid(confirmField);
            }
        }

        var titleField = form.querySelector('input[name="title"][maxlength]');
        if (titleField) {
            var maxLength = parseInt(titleField.getAttribute('maxlength'), 10);
            if (titleField.value.length > maxLength) {
                errors.push('Title must be ' + maxLength + ' characters or fewer.');
                markInvalid(titleField);
            }
        }

        return errors.filter(function (msg, index) {
            return errors.indexOf(msg) === index;
        });
    }

    function labelFor(field) {
        var label = field.closest('.form-group') &&
            field.closest('.form-group').querySelector('label');
        if (label) {
            return label.textContent.replace('*', '').trim();
        }
        return field.name || 'This field';
    }

    function markInvalid(field) {
        field.style.borderColor = '#dc2626';
    }

    function markValid(field) {
        field.style.borderColor = '';
    }

    function showErrors(form, errors) {
        var existing = form.parentNode.querySelector('.js-validation-errors');
        if (existing) {
            existing.remove();
        }

        var box = document.createElement('div');
        box.className = 'alert alert-error js-validation-errors';

        errors.forEach(function (message) {
            var p = document.createElement('p');
            p.textContent = message;
            box.appendChild(p);
        });

        form.parentNode.insertBefore(box, form);
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    document.querySelectorAll('form[novalidate] input, form[novalidate] textarea')
        .forEach(function (field) {
            field.addEventListener('input', function () {
                field.style.borderColor = '';
            });
        });
});