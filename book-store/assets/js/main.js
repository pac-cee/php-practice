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
  const menuToggle = document.querySelector('.mobile-menu-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');
  
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', function() {
      this.classList.toggle('active');
      mobileMenu.classList.toggle('active');
      
      // Toggle hamburger to X animation
      const spans = this.querySelectorAll('span');
      if (this.classList.contains('active')) {
        spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        spans[1].style.opacity = '0';
        spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
      } else {
        spans[0].style.transform = 'none';
        spans[1].style.opacity = '1';
        spans[2].style.transform = 'none';
      }
    });
  }
}

/**
 * Initialize accordion functionality for mobile menu
 */
function initAccordions() {
  const accordionToggles = document.querySelectorAll('.accordion-toggle');
  
  accordionToggles.forEach(toggle => {
    toggle.addEventListener('click', function(e) {
      e.preventDefault();
      
      const parent = this.closest('.mobile-accordion');
      parent.classList.toggle('active');
      
      const content = this.nextElementSibling;
      if (parent.classList.contains('active')) {
