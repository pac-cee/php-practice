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
");
$stmt->bind_param('i', $order_id);
$stmt->execute();
$orderInfo = $stmt->get_result()->fetch_assoc();
if (!$orderInfo) {
    header('Location: view_orders.php');
    exit;
}

// 2) Fetch all order_items for that order
$stmt2 = $conn->prepare("
  SELECT oi.book_id, oi.quantity, oi.price, b.title
  FROM order_items oi
  JOIN books b ON oi.book_id = b.id
  WHERE oi.order_id = ?
");
$stmt2->bind_param('i', $order_id);
$stmt2->execute();
$resItems = $stmt2->get_result();
