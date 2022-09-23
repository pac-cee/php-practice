<?php
/**
 * Get admin dashboard statistics
 * @param PDO $conn Database connection
 * @return array Statistics data
 */
function getAdminStats($conn) {
    // Total orders
    $stmt = $conn->prepare("SELECT COUNT(*) FROM orders");
    $stmt->execute();
    $totalOrders = $stmt->fetchColumn();
    
    // Orders this month
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM orders
        WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
        AND YEAR(created_at) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute();
