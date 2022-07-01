<?php
session_start();
require_once __DIR__ . '/config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Bookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A modern online bookstore to buy, sell, and manage books.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/72x72/1f4da.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Your CSS files -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="assets/css/book_catalog.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">

    <!-- Your main JS -->
    <script src="assets/js/main.js" defer></script>
</head>
<body class="fade-in">

    <nav>
        <a href="index.php" class="active"><i class="fas fa-house"></i> Home</a>
        <a href="views/book_catalog.php"><i class="fas fa-book-open"></i> Book Catalog</a>

        <?php if (isset($_SESSION['user_id'])): ?>
