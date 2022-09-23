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
    $ordersThisMonth = $stmt->fetchColumn();
    
    // Orders last month
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM orders
        WHERE MONTH(created_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
        AND YEAR(created_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
    ");
    $stmt->execute();
    $ordersLastMonth = $stmt->fetchColumn();
    
    // Calculate orders change percentage
    $ordersChange = 0;
    if ($ordersLastMonth > 0) {
        $ordersChange = round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100);
    }
    
    // Total revenue
    $stmt = $conn->prepare("SELECT SUM(total_amount) FROM orders");
    $stmt->execute();
    $totalRevenue = $stmt->fetchColumn() ?: 0;
    
    // Revenue this month
    $stmt = $conn->prepare("
        SELECT SUM(total_amount) FROM orders
        WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
        AND YEAR(created_at) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute();
    $revenueThisMonth = $stmt->fetchColumn() ?: 0;
    
    // Revenue last month
    $stmt = $conn->prepare("
        SELECT SUM(total_amount) FROM orders
        WHERE MONTH(created_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
        AND YEAR(created_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
    ");
    $stmt->execute();
    $revenueLastMonth = $stmt->fetchColumn() ?: 0;
    
    // Calculate revenue change percentage
    $revenueChange = 0;
    if ($revenueLastMonth > 0) {
        $revenueChange = round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100);
    }
    
    // Total users
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $totalUsers = $stmt->fetchColumn();
    
    // Users this month
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM users
        WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
        AND YEAR(created_at) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute();
    $usersThisMonth = $stmt->fetchColumn();
    
    // Users last month
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM users
        WHERE MONTH(created_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
        AND YEAR(created_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
    ");
    $stmt->execute();
    $usersLastMonth = $stmt->fetchColumn();
    
    // Calculate users change percentage
    $usersChange = 0;
    if ($usersLastMonth > 0) {
        $usersChange = round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100);
    }
    
    // Total books
