<?php
/**
 * Get reviews for a book
 * @param PDO $conn Database connection
 * @param int $bookId Book ID
 * @param int $limit Number of reviews to return
 * @param int $offset Offset for pagination
 * @return array Array of reviews
 */
function getBookReviews($conn, $bookId, $limit = 10, $offset = 0) {
    $stmt = $conn->prepare("
        SELECT r.*, u.name as user_name
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        WHERE r.book_id = :book_id
        ORDER BY r.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
