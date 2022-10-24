<?php
  session_start();
  
  // Redirect if not logged in
  if(!isset($_SESSION['user_id'])) {
    header("Location: ./login.php?redirect=checkout");
    exit;
  }
  
  require_once './backend/config/database.php';
  require_once './backend/functions/cart_functions.php';
  require_once './backend/functions/user_functions.php';
  
  // Get cart items
  $cartItems = [];
  if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cartItems = getCartItems($conn, $_SESSION['cart']);
  }
  
  // Redirect if cart is empty
  if(count($cartItems) === 0) {
    header("Location: ./cart.php");
    exit;
  }
  
  // Calculate totals
  $subtotal = 0;
  foreach($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
  }
  
  $tax = $subtotal * 0.08; // 8% tax
  $shipping = 5.99; // $5.99 shipping
  $total = $subtotal + $tax + $shipping;
  
  // Get user information
  $user = getUserById($conn, $_SESSION['user_id']);
  $addresses = getUserAddresses($conn, $_SESSION['user_id']);
  $paymentMethods = getUserPaymentMethods($conn, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - BookHaven</title>
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/checkout.css">
</head>
<body>
  <?php include './frontend/components/header.php'; ?>
  
  <main class="container">
    <h1>Checkout</h1>
    
    <div class="checkout-container">
      <div class="checkout-main">
