document.addEventListener('DOMContentLoaded', function() {
    initializeAuthForms();
    setupPasswordVisibility();
});

function initializeAuthForms() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    }
}

function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required]');

    inputs.forEach(input => {
        if (!input.value.trim()) {
            showError(input, 'This field is required');
            isValid = false;
        } else {
            removeError(input);
        }

