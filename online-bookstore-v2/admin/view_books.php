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

        if ($has_orders) {
            // Book has orders - set as inactive
            $update_stmt = $conn->prepare("UPDATE books SET active = 0 WHERE id = ?");
            if (!$update_stmt) {
                throw new Exception("Error preparing update statement: " . $conn->error);
            }
            $update_stmt->bind_param('i', $delete_id);
            $update_stmt->execute();
            $update_stmt->close();
            $_SESSION['message'] = "Book has existing orders. Marked as inactive instead of deleting.";
        } else {
            // No orders - safe to delete
            $delete_stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
            $delete_stmt->bind_param('i', $delete_id);
            $delete_stmt->execute();
            $delete_stmt->close();
            $_SESSION['message'] = "Book deleted successfully.";
        }
        
