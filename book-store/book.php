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
  <link rel="stylesheet" href="./assets/css/book.css">
</head>
<body>
  <?php include './frontend/components/header.php'; ?>
  
  <main class="container">
    <div class="book-detail-container">
      <div class="book-image">
        <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo $book['title']; ?>">
      </div>
      
      <div class="book-details">
        <div class="breadcrumbs">
          <a href="./catalog.php">Catalog</a> &gt; 
          <a href="./catalog.php?category=<?php echo $book['category_slug']; ?>"><?php echo $book['category_name']; ?></a> &gt; 
          <span><?php echo $book['title']; ?></span>
        </div>
        
        <h1><?php echo $book['title']; ?></h1>
