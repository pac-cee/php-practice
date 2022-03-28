<?php
// File: admin/view_orders.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

$error   = '';
$message = '';

// 1) Handle status update via GET (e.g., ?update_id=123&status=shipped)
if (isset($_GET['update_id'], $_GET['status'])) {
    $oid = intval($_GET['update_id']);
    $newStatus = $conn->real_escape_string($_GET['status']);
    $validStatuses = ['pending','paid','shipped','completed'];
    if (in_array($newStatus, $validStatuses)) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $newStatus, $oid);
        if ($stmt->execute()) {
            $message = "Order #$oid status updated to $newStatus.";
        } else {
            $error = "Error updating status: " . $conn->error;
        }
    }
    header('Location: view_orders.php');
    exit;
}

// 2) Fetch filters and build WHERE clause
$whereClauses = [];

if (!empty($_GET['search_user'])) {
    $uid = intval($_GET['search_user']);
    $whereClauses[] = "o.user_id = $uid";
}
if (!empty($_GET['status_filter'])) {
    $st = $conn->real_escape_string($_GET['status_filter']);
    $whereClauses[] = "o.status = '$st'";
}
if (!empty($_GET['date_from']) && !empty($_GET['date_to'])) {
    $df = $conn->real_escape_string($_GET['date_from']) . " 00:00:00";
    $dt = $conn->real_escape_string($_GET['date_to']) . " 23:59:59";
    $whereClauses[] = "o.order_date BETWEEN '$df' AND '$dt'";
}

$whereSQL = '';
if (count($whereClauses)) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

// 3) Main query: join users + aggregated order total
//    We compute total_amount by summing order_items.price * quantity per order.
$sql = "
  SELECT 
    o.id AS order_id,
    u.username,
    o.status,
    o.order_date,
    IFNULL(SUM(oi.price * oi.quantity), 0) AS total_amount
  FROM orders o
  JOIN users u ON o.user_id = u.id
  LEFT JOIN order_items oi ON o.id = oi.order_id
  $whereSQL
  GROUP BY o.id, u.username, o.status, o.order_date
  ORDER BY o.order_date DESC
";
$resOrders = $conn->query($sql);

// 4) Fetch all users for “search by user” dropdown
$resUsers = $conn->query("SELECT id, username FROM users ORDER BY username ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Orders • Admin</title>
  <link rel="stylesheet" href="/css/index.css">
