document.addEventListener('DOMContentLoaded', function() {
  // Initialize dropdowns
  initDropdowns();
  
  // Initialize mobile menu
  initMobileMenu();
  
  // Initialize accordions
  initAccordions();
  
  // Initialize password toggles
  initPasswordToggles();
});

/**
 * Initialize dropdown functionality
 */
function initDropdowns() {
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
