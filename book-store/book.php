<?php
  session_start();
  require_once './backend/config/database.php';
  require_once './backend/functions/book_functions.php';
  require_once './backend/functions/review_functions.php';
  
  // Get book ID from URL
  $bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  
  // Redirect if no book ID
  if($bookId === 0) {
    header("Location: ./catalog.php");
    exit;
  }
  
  // Get book details
  $book = getBookById($conn, $bookId);
  
  // Redirect if book not found
  if(!$book) {
    header("Location: ./catalog.php");
    exit;
  }
  
  // Get related books
  $relatedBooks = getRelatedBooks($conn, $bookId, $book['category_id'], 4);
  
  // Get reviews
  $reviews = getBookReviews($conn, $bookId);
  $avgRating = getAverageRating($conn, $bookId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $book['title']; ?> - BookHaven</title>
  <link rel="stylesheet" href="./assets/css/main.css">
