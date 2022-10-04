<?php
/**
 * Get user by ID
 * @param PDO $conn Database connection
 * @param int $userId User ID
 * @return array|false User data or false if not found
 */
function getUserById($conn, $userId) {
    $stmt = $conn->prepare("
        SELECT id, name, email, is_admin, created_at
        FROM users
        WHERE id = :id
    ");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch();
}

