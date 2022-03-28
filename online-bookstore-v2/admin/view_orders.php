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
