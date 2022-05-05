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
