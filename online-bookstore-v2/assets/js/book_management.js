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
    });

    // Setup edit buttons
    const editButtons = table.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.querySelector('td:first-child').textContent;
            handleEdit(id);
        });
    });

    // Setup delete buttons
    const deleteButtons = table.querySelectorAll('.delete-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.querySelector('td:first-child').textContent;
            handleDelete(id, row);
        });
    });
}

function handleEdit(id) {
    // Create edit form
    const row = document.querySelector(`tr[data-id="${id}"]`);
    const cells = row.querySelectorAll('td');
    
    cells.forEach((cell, index) => {
        if (index > 0 && index < cells.length - 1) {
            const text = cell.textContent;
            const input = document.createElement('input');
            input.type = index === 3 ? 'number' : 'text';
            input.value = text;
            input.step = index === 3 ? '0.01' : null;
            cell.textContent = '';
            cell.appendChild(input);
        }
