<?php
// File: admin/view_order_detail.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

if (!isset($_GET['order_id'])) {
    header('Location: view_orders.php');
    exit;
}

$order_id = intval($_GET['order_id']);

// 1) Fetch order & user info
$stmt = $conn->prepare("
  SELECT o.id, o.user_id, o.status, o.order_date, u.username, u.email
  FROM orders o
  JOIN users u ON o.user_id = u.id
  WHERE o.id = ? LIMIT 1
