<?php
  session_start();
  
  // Redirect if already logged in
  if(isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
  }
  
  // Check for redirect parameter
  $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';
  
  // Check for error messages
  $error = isset($_GET['error']) ? $_GET['error'] : '';
  $errorMsg = '';
  
  if($error === 'email') {
    $errorMsg = 'Email is already registered. Please use a different email or log in.';
  } elseif($error === 'password') {
    $errorMsg = 'Passwords do not match.';
  } elseif($error === 'empty') {
    $errorMsg = 'Please fill in all fields.';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - BookHaven</title>
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/auth.css">
</head>
<body>
  <?php include './frontend/components/header.php'; ?>
  
  <main class="auth-container">
    <div class="auth-form-container">
