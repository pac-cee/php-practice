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
        <p class="author">by <a href="./catalog.php?author=<?php echo urlencode($book['author']); ?>"><?php echo $book['author']; ?></a></p>
        
        <div class="book-meta">
          <div class="rating">
            <div class="stars" data-rating="<?php echo $avgRating; ?>">
              <?php for($i = 1; $i <= 5; $i++): ?>
                <span class="star <?php echo ($i <= $avgRating) ? 'filled' : ''; ?>">★</span>
              <?php endfor; ?>
            </div>
            <span class="rating-count">(<?php echo count($reviews); ?> reviews)</span>
          </div>
          
          <div class="price-container">
            <span class="price">$<?php echo number_format($book['price'], 2); ?></span>
            <?php if($book['original_price'] > $book['price']): ?>
              <span class="original-price">$<?php echo number_format($book['original_price'], 2); ?></span>
              <span class="discount">Save <?php echo round((($book['original_price'] - $book['price']) / $book['original_price']) * 100); ?>%</span>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="book-actions">
          <div class="quantity">
            <button class="quantity-btn" id="decrease-quantity">-</button>
            <input type="number" id="quantity" value="1" min="1" max="99">
            <button class="quantity-btn" id="increase-quantity">+</button>
          </div>
          <button class="btn btn-primary" id="add-to-cart" data-book-id="<?php echo $book['id']; ?>">
            Add to Cart
          </button>
          <button class="btn btn-outline" id="add-to-wishlist" data-book-id="<?php echo $book['id']; ?>">
            <i class="icon-heart"></i> Add to Wishlist
          </button>
        </div>
        
        <div class="book-availability">
          <p><strong>Availability:</strong> <?php echo ($book['stock_quantity'] > 0) ? 'In Stock' : 'Out of Stock'; ?></p>
          <?php if($book['stock_quantity'] > 0 && $book['stock_quantity'] < 10): ?>
