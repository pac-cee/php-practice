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
            <!-- If a normal user is logged in -->
            <a href="views/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="views/quiz.php"><i class="fas fa-question-circle"></i> Quizzes</a>
            <a href="views/quiz_results.php"><i class="fas fa-list-ol"></i> Quiz Results</a>
            <a href="views/orders.php"><i class="fas fa-shopping-cart"></i> My Orders</a>
            <a href="views/progress.php"><i class="fas fa-chart-line"></i> My Progress</a>
            <a href="views/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <!-- If the logged-in user is an admin, show link to Admin Dashboard -->
                <a href="admin/dashboard.php"><i class="fas fa-user-shield"></i> Admin Dashboard</a>
            <?php else: ?>
                <!-- If a normal user is logged in, but not admin, show Admin Login -->
                <a href="admin/admin_login.php"><i class="fas fa-user-shield"></i> Admin Login</a>
            <?php endif; ?>

        <?php else: ?>
            <!-- No one is logged in -->
            <a href="views/register.php"><i class="fas fa-user-plus"></i> Register</a>
