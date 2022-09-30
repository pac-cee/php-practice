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
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Get average rating for a book
 * @param PDO $conn Database connection
 * @param int $bookId Book ID
 * @return float Average rating
 */
function getAverageRating($conn, $bookId) {
    $stmt = $conn->prepare("
        SELECT AVG(rating) FROM reviews WHERE book_id = :book_id
    ");
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    
    $avg = $stmt->fetchColumn();
    return $avg ? round($avg, 1) : 0;
}

/**
 * Add a review
 * @param PDO $conn Database connection
 * @param int $bookId Book ID
 * @param int $userId User ID
 * @param int $rating Rating (1-5)
 * @param string $title Review title
 * @param string $content Review content
 * @return int|false New review ID or false on failure
 */
function addReview($conn, $bookId, $userId, $rating, $title, $content) {
    // Check if user has already reviewed this book
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM reviews
