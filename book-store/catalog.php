<?php
  session_start();
  require_once './backend/config/database.php';
  require_once './backend/functions/book_functions.php';
  
  // Get query parameters
  $category = isset($_GET['category']) ? $_GET['category'] : '';
  $search = isset($_GET['search']) ? $_GET['search'] : '';
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $perPage = 12;
  
  // Get books based on filters
  $books = getFilteredBooks($conn, $category, $search, $page, $perPage);
  $totalBooks = getTotalFilteredBooks($conn, $category, $search);
  $totalPages = ceil($totalBooks / $perPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Catalog - BookHaven</title>
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/catalog.css">
</head>
<body>
  <?php include './frontend/components/header.php'; ?>
  
  <main class="container">
    <section class="catalog-header">
      <h1>Book Catalog</h1>
      <?php if($category): ?>
        <p>Category: <span class="highlight"><?php echo ucfirst($category); ?></span></p>
      <?php endif; ?>
      <?php if($search): ?>
        <p>Search results for: <span class="highlight"><?php echo htmlspecialchars($search); ?></span></p>
      <?php endif; ?>
    </section>

    <div class="catalog-container">
      <aside class="filters">
        <div class="filter-section">
          <h3>Categories</h3>
          <ul class="category-list">
            <li><a href="./catalog.php" <?php echo empty($category) ? 'class="active"' : ''; ?>>All Categories</a></li>
            <li><a href="./catalog.php?category=fiction" <?php echo $category === 'fiction' ? 'class="active"' : ''; ?>>Fiction</a></li>
            <li><a href="./catalog.php?category=non-fiction" <?php echo $category === 'non-fiction' ? 'class="active"' : ''; ?>>Non-Fiction</a></li>
            <li><a href="./catalog.php?category=mystery" <?php echo $category === 'mystery' ? 'class="active"' : ''; ?>>Mystery</a></li>
            <li><a href="./catalog.php?category=science-fiction" <?php echo $category === 'science-fiction' ? 'class="active"' : ''; ?>>Science Fiction</a></li>
            <li><a href="./catalog.php?category=biography" <?php echo $category === 'biography' ? 'class="active"' : ''; ?>>Biography</a></li>
            <li><a href="./catalog.php?category=history" <?php echo $category === 'history' ? 'class="active"' : ''; ?>>History</a></li>
          </ul>
        </div>
        
        <div class="filter-section">
          <h3>Price Range</h3>
          <div class="price-slider">
