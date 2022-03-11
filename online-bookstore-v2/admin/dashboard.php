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
