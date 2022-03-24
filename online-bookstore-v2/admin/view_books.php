<?php
// File: admin/view_books.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

// Handle Delete action if present
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    try {
        // First check if book has any orders
        $check_stmt = $conn->prepare("SELECT COUNT(*) as order_count FROM orders WHERE book_id = ?");
        $check_stmt->bind_param('i', $delete_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $has_orders = $result->fetch_assoc()['order_count'] > 0;
        $check_stmt->close();

