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
        <form id="checkout-form" action="./backend/api/place_order.php" method="POST">
          <div class="checkout-section shipping-address">
            <h2>Shipping Address</h2>
            
            <?php if(count($addresses) > 0): ?>
              <div class="saved-addresses">
                <h3>Select a Saved Address</h3>
                <?php foreach($addresses as $index => $address): ?>
                  <div class="address-option">
                    <input type="radio" name="selected_address" id="address-<?php echo $address['id']; ?>" value="<?php echo $address['id']; ?>" <?php echo ($index === 0) ? 'checked' : ''; ?>>
                    <label for="address-<?php echo $address['id']; ?>" class="address-card">
                      <div class="address-info">
                        <p><strong><?php echo $address['name']; ?></strong></p>
                        <p><?php echo $address['street_address']; ?></p>
                        <p><?php echo $address['city']; ?>, <?php echo $address['state']; ?> <?php echo $address['zip_code']; ?></p>
                        <p><?php echo $address['country']; ?></p>
                        <p>Phone: <?php echo $address['phone']; ?></p>
                      </div>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
              
              <div class="address-toggle">
                <button type="button" id="new-address-toggle" class="btn btn-link">
                  + Add New Address
                </button>
              </div>
            <?php endif; ?>
            
            <div class="new-address-form <?php echo (count($addresses) > 0) ? 'hidden' : ''; ?>">
              <div class="form-row">
                <div class="form-group">
                  <label for="name">Full Name</label>
                  <input type="text" id="name" name="name" required value="<?php echo $user['name']; ?>">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" required value="<?php echo $user['email']; ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label for="address">Street Address</label>
                <input type="text" id="address" name="address" required>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="city">City</label>
                  <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                  <label for="state">State/Province</label>
                  <input type="text" id="state" name="state" required>
                </div>
              </div>
