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
