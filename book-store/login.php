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
  
  if($error === 'invalid') {
    $errorMsg = 'Invalid email or password.';
  } elseif($error === 'empty') {
