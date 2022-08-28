<?php
  session_start();
  
  // Check if user is admin
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php");
    exit;
  }
  
  require_once '../backend/config/database.php';
  require_once '../backend/functions/admin_functions.php';
  
  // Get statistics
  $stats = getAdminStats($conn);
  
  // Get recent orders
  $recentOrders = getRecentOrders($conn, 5);
  
  // Get low stock books
