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
      menu.style.display = parent.classList.contains('active') ? 'block' : 'none';
    });
  });
  
  // Close dropdowns when clicking outside
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
      document.querySelectorAll('.dropdown.active').forEach(dropdown => {
        dropdown.classList.remove('active');
        dropdown.querySelector('.dropdown-menu').style.display = 'none';
      });
    }
  });
}

/**
 * Initialize mobile menu functionality
 */
function initMobileMenu() {
