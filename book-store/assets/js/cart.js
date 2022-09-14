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
    }
  }
}

/**
 * Animate cart icon when adding an item
 */
function animateCartIcon() {
  const cartIcon = document.querySelector('.icon-cart');
  if (cartIcon) {
    // Add animation class
    cartIcon.classList.add('cart-animated');
    
    // Remove class after animation completes
    setTimeout(() => {
      cartIcon.classList.remove('cart-animated');
    }, 500);
  }
}

/**
 * Update cart item quantity
 * @param {string} bookId - The ID of the book to update
 * @param {number} quantity - The new quantity
 */
function updateCartQuantity(bookId, quantity) {
  // Make AJAX request
  fetch('./backend/api/cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `action=update&book_id=${bookId}&quantity=${quantity}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update cart count in header
      updateCartCount(data.cartCount);
    } else {
      // Show error notification
      showNotification(data.message, 'error');
    }
  })
  .catch(error => {
    console.error('Error updating cart:', error);
    showNotification('Failed to update cart. Please try again.', 'error');
  });
}

/**
 * Remove an item from the cart
 * @param {string} bookId - The ID of the book to remove
 */
function removeFromCart(bookId) {
  // Make AJAX request
  fetch('./backend/api/cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `action=remove&book_id=${bookId}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update cart count in header
      updateCartCount(data.cartCount);
      
      // Show success notification
      showNotification('Item removed from cart', 'success');
      
      // Remove item from cart page if we're on it
      const cartItem = document.querySelector(`.cart-item[data-book-id="${bookId}"]`);
      if (cartItem) {
        cartItem.classList.add('removing');
        setTimeout(() => {
          cartItem.remove();
          updateCartTotals();
          
          // Check if cart is empty
          const cartItems = document.querySelectorAll('.cart-item');
          if (cartItems.length === 0) {
            location.reload(); // Reload to show empty cart message
          }
        }, 300);
      }
    } else {
      // Show error notification
      showNotification(data.message, 'error');
    }
  })
  .catch(error => {
    console.error('Error removing from cart:', error);
    showNotification('Failed to remove item from cart. Please try again.', 'error');
