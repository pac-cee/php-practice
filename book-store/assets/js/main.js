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
  
  dropdownToggles.forEach(toggle => {
    const parent = toggle.closest('.dropdown');
    const menu = parent.querySelector('.dropdown-menu');
    
    // Toggle dropdown on click instead of hover for better mobile experience
    toggle.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Close other open dropdowns
      document.querySelectorAll('.dropdown.active').forEach(activeDropdown => {
        if (activeDropdown !== parent) {
          activeDropdown.classList.remove('active');
          activeDropdown.querySelector('.dropdown-menu').style.display = 'none';
        }
      });
      
      // Toggle current dropdown
      parent.classList.toggle('active');
