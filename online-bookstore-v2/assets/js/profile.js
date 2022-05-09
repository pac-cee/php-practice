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
