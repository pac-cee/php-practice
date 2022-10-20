<?php
  session_start();
  require_once './backend/config/database.php';
  require_once './backend/functions/cart_functions.php';
  
  // Get cart items
  $cartItems = [];
  if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cartItems = getCartItems($conn, $_SESSION['cart']);
  }
  
  // Calculate totals
  $subtotal = 0;
  foreach($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
  }
  
  $tax = $subtotal * 0.08; // 8% tax
  $shipping = ($subtotal > 0) ? 5.99 : 0; // $5.99 shipping, free if cart is empty
