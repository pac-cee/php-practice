<?php
  session_start();
  require_once './backend/config/database.php';
  require_once './backend/functions/book_functions.php';
  
  // Get featured books
  $featuredBooks = getFeaturedBooks($conn, 4);
  $newArrivals = getNewArrivals($conn, 8);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookHaven - Your Online Bookstore</title>
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/home.css">
</head>
<body>
  <?php include './frontend/components/header.php'; ?>
  
  <main>
    <section class="hero">
      <div class="hero-content">
        <h1>Discover Your Next Favorite Book</h1>
        <p>Explore thousands of titles across every genre imaginable</p>
        <a href="./catalog.php" class="btn btn-primary">Browse Catalog</a>
      </div>
    </section>

    <section class="featured container">
      <h2>Featured Books</h2>
      <div class="book-grid">
        <?php foreach($featuredBooks as $book): ?>
          <div class="book-card" data-book-id="<?php echo $book['id']; ?>">
            <div class="book-cover">
              <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo $book['title']; ?>">
            </div>
