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
    $stmt = $conn->prepare("SELECT COUNT(*) FROM books");
    $stmt->execute();
    $totalBooks = $stmt->fetchColumn();
    
    // Books added this month
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM books
        WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
        AND YEAR(created_at) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute();
    $booksThisMonth = $stmt->fetchColumn();
    
    return [
        'total_orders' => $totalOrders,
        'orders_this_month' => $ordersThisMonth,
        'orders_change' => $ordersChange,
        'total_revenue' => $totalRevenue,
        'revenue_this_month' => $revenueThisMonth,
        'revenue_change' => $revenueChange,
        'total_users' => $totalUsers,
        'users_this_month' => $usersThisMonth,
        'users_change' => $usersChange,
        'total_books' => $totalBooks,
        'books_change' => $booksThisMonth
    ];
}

/**
 * Get recent orders for admin
 * @param PDO $conn Database connection
 * @param int $limit Number of orders to return
 * @return array Recent orders
 */
function getRecentOrders($conn, $limit = 5) {
    $stmt = $conn->prepare("
        SELECT o.*, u.name as user_name
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at DESC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Get low stock books
 * @param PDO $conn Database connection
 * @param int $limit Number of books to return
 * @param int $threshold Low stock threshold
 * @return array Low stock books
 */
function getLowStockBooks($conn, $limit = 5, $threshold = 5) {
    $stmt = $conn->prepare("
        SELECT *
        FROM books
        WHERE stock_quantity <= :threshold
        ORDER BY stock_quantity ASC
        LIMIT :limit
    ");
    $stmt->bindParam(':threshold', $threshold, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Get all users for admin
 * @param PDO $conn Database connection
 * @param int $limit Number of users to return
 * @param int $offset Offset for pagination
 * @return array Users
 */
function getAllUsers($conn, $limit = 10, $offset = 0) {
    $stmt = $conn->prepare("
        SELECT id, name, email, is_admin, created_at,
               (SELECT COUNT(*) FROM orders WHERE user_id = users.id) as order_count
        FROM users
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Get total users count
 * @param PDO $conn Database connection
 * @return int Total users
 */
function getTotalUsers($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    
    return $stmt->fetchColumn();
}

/**
 * Create a new admin user
 * @param PDO $conn Database connection
 * @param array $userData User data
 * @return int|false New user ID or false on failure
 */
function createAdminUser($conn, $userData) {
    // Check if email already exists
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM users WHERE email = :email
    ");
    $stmt->bindParam(':email', $userData['email']);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        return false; // Email already exists
    }
    
    // Hash password
    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    
    // Insert new admin user
    $stmt = $conn->prepare("
        INSERT INTO users (name, email, password, is_admin)
        VALUES (:name, :email, :password, 1)
    ");
    $stmt->bindParam(':name', $userData['name']);
    $stmt->bindParam(':email', $userData['email']);
    $stmt->bindParam(':password', $hashedPassword);
