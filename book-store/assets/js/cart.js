document.addEventListener('DOMContentLoaded', function() {
  initAddToCartButtons();
});

/**
 * Initialize add to cart buttons
 */
function initAddToCartButtons() {
  const addToCartButtons = document.querySelectorAll('.add-to-cart');
  
  addToCartButtons.forEach(button => {
    button.addEventListener('click', function() {
      const bookId = this.dataset.bookId;
      const quantity = 1; // Default quantity
      
      addToCart(bookId, quantity);
    });
  });
}

/**
 * Add a book to the cart
 * @param {string} bookId - The ID of the book to add
 * @param {number} quantity - The quantity to add
 */
function addToCart(bookId, quantity = 1) {
  // Show loading state
  const button = document.querySelector(`.add-to-cart[data-book-id="${bookId}"]`);
  if (button) {
    const originalText = button.textContent;
    button.disabled = true;
    button.textContent = 'Adding...';
  }
  
  // Make AJAX request
  fetch('./backend/api/cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `action=add&book_id=${bookId}&quantity=${quantity}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update cart count in header
      updateCartCount(data.cartCount);
      
      // Show success notification
      showNotification(data.message, 'success');
      
      // Animate cart icon
      animateCartIcon();
    } else {
      // Show error notification
      showNotification(data.message, 'error');
    }
    
    // Reset button state
    if (button) {
      button.disabled = false;
      button.textContent = 'Add to Cart';
    }
  })
  .catch(error => {
    console.error('Error adding to cart:', error);
    
    // Show error notification
    showNotification('Failed to add item to cart. Please try again.', 'error');
    
    // Reset button state
    if (button) {
      button.disabled = false;
      button.textContent = 'Add to Cart';
    }
  });
}

/**
 * Update cart count in header
 * @param {number} count - The new cart count
 */
function updateCartCount(count) {
  let cartCountElement = document.querySelector('.cart-count');
  
  if (count > 0) {
    if (!cartCountElement) {
      cartCountElement = document.createElement('span');
      cartCountElement.className = 'cart-count';
      document.querySelector('.cart-action').appendChild(cartCountElement);
    }
    cartCountElement.textContent = count;
  } else {
    if (cartCountElement) {
      cartCountElement.remove();
