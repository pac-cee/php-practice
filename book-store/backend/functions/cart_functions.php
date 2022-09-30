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
 * @param int $bookId Book ID
 * @return array Updated cart array
 */
function removeFromCart($cart, $bookId) {
    if (isset($cart[$bookId])) {
        unset($cart[$bookId]);
    }
    
    return $cart;
}

/**
 * Clear cart
 * @return array Empty cart array
 */
function clearCart() {
    return [];
}

/**
 * Get total items in cart
 * @param array $cart Cart array
 * @return int Total number of items
 */
function getCartCount($cart) {
    if (!$cart) {
        return 0;
    }
    
    return array_sum($cart);
}

/**
 * Get cart items with book details
 * @param PDO $conn Database connection
 * @param array $cart Cart array
 * @return array Cart items with details
 */
function getCartItems($conn, $cart) {
    if (empty($cart)) {
        return [];
    }
    
    $bookIds = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($bookIds), '?'));
    
    $stmt = $conn->prepare("
        SELECT * FROM books WHERE id IN ($placeholders)
    ");
    
    // Bind all book IDs as parameters
    $index = 1;
    foreach ($bookIds as $id) {
        $stmt->bindValue($index++, $id, PDO::PARAM_INT);
    }
    
    $stmt->execute();
