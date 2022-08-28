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
  $lowStockBooks = getLowStockBooks($conn, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - BookHaven</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="admin-layout">
    <?php include './components/sidebar.php'; ?>
    
    <div class="admin-content">
      <?php include './components/header.php'; ?>
      
      <main class="admin-main">
