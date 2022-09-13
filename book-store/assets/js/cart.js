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
