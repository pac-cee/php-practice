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
