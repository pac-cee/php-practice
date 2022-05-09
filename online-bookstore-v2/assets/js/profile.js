document.addEventListener('DOMContentLoaded', function() {
    initializeProfileForm();
    initializePasswordValidation();
});

function initializeProfileForm() {
    const form = document.getElementById('profileUpdateForm');
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }

        const formData = new FormData(form);
        try {
            const response = await fetch('../controllers/update_profile.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (data.success) {
                showMessage('Profile updated successfully!', 'success');
                if (formData.get('new_password')) {
                    form.reset();
                }
            } else {
                showMessage(data.message || 'Error updating profile', 'error');
            }
        } catch (error) {
            showMessage('Error updating profile', 'error');
            console.error('Error:', error);
        }
    });
}

function validateForm() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const email = document.getElementById('email');
    
    let isValid = true;

    // Validate email
    if (email.value && !isValidEmail(email.value)) {
        showError(email, 'Please enter a valid email address');
        isValid = false;
    } else {
        removeError(email);
    }

    // Validate passwords if either field is filled
    if (newPassword.value || confirmPassword.value) {
        if (newPassword.value.length < 6) {
            showError(newPassword, 'Password must be at least 6 characters');
            isValid = false;
        } else {
            removeError(newPassword);
        }

        if (newPassword.value !== confirmPassword.value) {
            showError(confirmPassword, 'Passwords do not match');
            isValid = false;
        } else {
            removeError(confirmPassword);
        }
    }

    return isValid;
}

function initializePasswordValidation() {
    const newPassword = document.getElementById('new_password');
