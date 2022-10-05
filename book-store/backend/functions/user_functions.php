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

/**
 * Get user by email
 * @param PDO $conn Database connection
 * @param string $email User email
 * @return array|false User data or false if not found
 */
function getUserByEmail($conn, $email) {
    $stmt = $conn->prepare("
        SELECT id, name, email, is_admin, created_at
        FROM users
        WHERE email = :email
    ");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetch();
}

/**
 * Update user profile
 * @param PDO $conn Database connection
 * @param int $userId User ID
 * @param array $userData User data to update
 * @return bool Success or failure
 */
function updateUserProfile($conn, $userId, $userData) {
    $stmt = $conn->prepare("
        UPDATE users
        SET name = :name, updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
    ");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':name', $userData['name'], PDO::PARAM_STR);
    
    return $stmt->execute();
}

/**
 * Change user password
 * @param PDO $conn Database connection
 * @param int $userId User ID
 * @param string $currentPassword Current password
 * @param string $newPassword New password
 * @return bool|string Success or error message
 */
function changeUserPassword($conn, $userId, $currentPassword, $newPassword) {
    // Get current password hash
    $stmt = $conn->prepare("
        SELECT password FROM users WHERE id = :id
    ");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $user = $stmt->fetch();
    
    if (!$user) {
        return 'User not found';
    }
    
    // Verify current password
    if (!password_verify($currentPassword, $user['password'])) {
        return 'Current password is incorrect';
    }
    
    // Update to new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("
        UPDATE users
        SET password = :password, updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
    ");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    
    return $stmt->execute();
}

/**
 * Get user addresses
 * @param PDO $conn Database connection
 * @param int $userId User ID
 * @return array User addresses
 */
function getUserAddresses($conn, $userId) {
    $stmt = $conn->prepare("
        SELECT * FROM addresses
        WHERE user_id = :user_id
        ORDER BY is_default DESC, created_at DESC
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}
