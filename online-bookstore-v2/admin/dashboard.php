<?php
// File: admin/dashboard.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

$stats         = getStats();
$lowStockRes   = getLowStockBooks();      // threshold = 5 by default
$pendingOrders = getPendingOrders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard • OnlineBookstore</title>
  <link rel="stylesheet" href="/css/index.css">
  <link rel="stylesheet" href="/css/dashboard.css">
  <link rel="stylesheet" href="/admin/css/admin.css">
</head>
<body>
  <?php include __DIR__ . '/../views/includes/header.php'; ?>

  <div class="admin-container">
    <h1 class="admin-title">Admin Dashboard</h1>

    <!-- KPI Cards -->
    <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem;">
      <div class="admin-card" style="flex: 1 1 200px;">
        <h3>Total Books</h3>
        <p style="font-size: 2rem;"><?= intval($stats['total_books']) ?></p>
      </div>
      <div class="admin-card" style="flex: 1 1 200px;">
        <h3>Total Users</h3>
        <p style="font-size: 2rem;"><?= intval($stats['total_users']) ?></p>
      </div>
      <div class="admin-card" style="flex: 1 1 200px;">
        <h3>Total Orders</h3>
        <p style="font-size: 2rem;"><?= intval($stats['total_orders']) ?></p>
