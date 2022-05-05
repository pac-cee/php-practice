document.addEventListener('DOMContentLoaded', function() {
    initializeBookForms();
    setupTableInteractions();
    initializeSearch();
});

function initializeBookForms() {
    const addBookForm = document.getElementById('addBookForm');
    
    if (addBookForm) {
        addBookForm.addEventListener('submit', function(e) {
            if (!validateBookForm(this)) {
                e.preventDefault();
            }
        });
    }
}

function validateBookForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            showError(input, 'This field is required');
            isValid = false;
        } else {
            removeError(input);
            
            if (input.name === 'price') {
                const price = parseFloat(input.value);
                if (isNaN(price) || price <= 0) {
                    showError(input, 'Please enter a valid price');
                    isValid = false;
                }
            }
        }
    });
    
    return isValid;
}

function setupTableInteractions() {
    const table = document.querySelector('.books-table');
    if (!table) return;

    // Add row hover effect
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'none';
        });
