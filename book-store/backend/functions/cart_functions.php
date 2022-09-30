<?php
/**
 * Add item to cart
 * @param array $cart Current cart array
 * @param int $bookId Book ID
 * @param int $quantity Quantity to add
 * @return array Updated cart array
 */
function addToCart($cart, $bookId, $quantity = 1) {
    if (isset($cart[$bookId])) {
        $cart[$bookId] += $quantity;
    } else {
        $cart[$bookId] = $quantity;
    }
    
    return $cart;
}

/**
 * Update cart item quantity
 * @param array $cart Current cart array
 * @param int $bookId Book ID
 * @param int $quantity New quantity
 * @return array Updated cart array
 */
function updateCartItem($cart, $bookId, $quantity) {
    if ($quantity <= 0) {
        return removeFromCart($cart, $bookId);
    }
    
    $cart[$bookId] = $quantity;
    
    return $cart;
}

/**
 * Remove item from cart
 * @param array $cart Current cart array
