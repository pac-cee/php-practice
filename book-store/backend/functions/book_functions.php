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
    
    // Add category filter
    if (!empty($category)) {
        $sql .= " AND c.slug = :category";
        $params[':category'] = $category;
    }
    
    // Add search filter
    if (!empty($search)) {
        $sql .= " AND (b.title LIKE :search OR b.author LIKE :search OR b.isbn LIKE :search)";
        $params[':search'] = "%$search%";
    }
    
    // Add sorting (default to newest)
    $sql .= " ORDER BY b.created_at DESC";
    
    // Add pagination
    $sql .= " LIMIT :limit OFFSET :offset";
    $params[':limit'] = $perPage;
    $params[':offset'] = $offset;
    
    // Prepare and execute
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        if ($key === ':limit' || $key === ':offset') {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
    }
    $stmt->execute();
    
    return $stmt->fetchAll();
}

/**
 * Get total filtered books count
 * @param PDO $conn Database connection
 * @param string $category Category slug
 * @param string $search Search term
 * @return int Total number of filtered books
 */
function getTotalFilteredBooks($conn, $category = '', $search = '') {
    $params = [];
    $sql = "
        SELECT COUNT(*) FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        WHERE 1=1
    ";
    
    // Add category filter
    if (!empty($category)) {
        $sql .= " AND c.slug = :category";
        $params[':category'] = $category;
    }
    
    // Add search filter
    if (!empty($search)) {
        $sql .= " AND (b.title LIKE :search OR b.author LIKE :search OR b.isbn LIKE :search)";
        $params[':search'] = "%$search%";
    }
    
    // Prepare and execute
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }
    $stmt->execute();
    
    return $stmt->fetchColumn();
}

/**
 * Get book by ID
 * @param PDO $conn Database connection
 * @param int $bookId Book ID
 * @return array|false Book data or false if not found
 */
function getBookById($conn, $bookId) {
    $stmt = $conn->prepare("
        SELECT b.*, c.name as category_name, c.slug as category_slug
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        WHERE b.id = :id
    ");
    $stmt->bindParam(':id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch();
}

/**
 * Get related books
 * @param PDO $conn Database connection
 * @param int $bookId Current book ID
 * @param int $categoryId Category ID for related books
 * @param int $limit Number of books to return
 * @return array Array of related books
 */
function getRelatedBooks($conn, $bookId, $categoryId, $limit = 4) {
    $stmt = $conn->prepare("
        SELECT b.*, c.name as category_name, c.slug as category_slug
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        WHERE b.id != :book_id AND b.category_id = :category_id
        ORDER BY RAND()
        LIMIT :limit
    ");
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
}
