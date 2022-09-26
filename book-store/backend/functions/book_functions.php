<?php
/**
 * Get all books
 * @param PDO $conn Database connection
 * @param int $limit Number of books to return
 * @param int $offset Offset for pagination
 * @return array Array of books
 */
function getAllBooks($conn, $limit = 12, $offset = 0) {
    $stmt = $conn->prepare("
        SELECT b.*, c.name as category_name, c.slug as category_slug
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        ORDER BY b.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
