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
    
    return $stmt->fetchAll();
}

/**
 * Get total number of books
 * @param PDO $conn Database connection
 * @return int Total number of books
 */
function getTotalBooks($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM books");
    $stmt->execute();
    
    return $stmt->fetchColumn();
}

/**
 * Get featured books
 * @param PDO $conn Database connection
 * @param int $limit Number of books to return
 * @return array Array of featured books
 */
function getFeaturedBooks($conn, $limit = 4) {
    $stmt = $conn->prepare("
        SELECT b.*, c.name as category_name, c.slug as category_slug
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        WHERE b.featured = 1
        ORDER BY RAND()
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Get new arrivals
 * @param PDO $conn Database connection
 * @param int $limit Number of books to return
 * @return array Array of new arrival books
 */
function getNewArrivals($conn, $limit = 8) {
    $stmt = $conn->prepare("
        SELECT b.*, c.name as category_name, c.slug as category_slug
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        ORDER BY b.created_at DESC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Get books with filters
 * @param PDO $conn Database connection
 * @param string $category Category slug
 * @param string $search Search term
 * @param int $page Current page for pagination
 * @param int $perPage Items per page
 * @return array Array of filtered books
 */
function getFilteredBooks($conn, $category = '', $search = '', $page = 1, $perPage = 12) {
    $offset = ($page - 1) * $perPage;
    $params = [];
    $sql = "
        SELECT b.*, c.name as category_name, c.slug as category_slug
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        WHERE 1=1
    ";
    
