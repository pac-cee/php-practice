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
