<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);
    $db = new Database();
    $conn = $db->getConnection();
    // Check if already ordered
    $stmt = $conn->prepare('SELECT id FROM orders WHERE user_id = ? AND book_id = ?');
    $stmt->bind_param('ii', $user_id, $book_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $message = 'You have already ordered this book.';
    } else {
        $stmt = $conn->prepare('INSERT INTO orders (user_id, book_id, status) VALUES (?, ?, ?)');
        $status = 'pending';
        $stmt->bind_param('iis', $user_id, $book_id, $status);
        if ($stmt->execute()) {
            $message = 'Book ordered successfully!';
        } else {
            $message = 'Failed to order book. Please try again.';
        }
    }
    $stmt->close();
    $conn->close();
} else {
    $message = 'Invalid request.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A modern online bookstore to buy, sell, and manage books.">
    <link rel="icon" type="image/png" href="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/72x72/1f4da.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/book_catalog.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <script src="/assets/js/main.js" defer></script>
    <style>
        /* Only keep unique dashboard layout tweaks, rely on styles.css for shared UI */
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--bg);
            min-height: 100vh;
            padding-bottom: 2em;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(42,82,152,0.10);
        }
        .dashboard-hero-img img {
            max-width: 160px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(42,82,152,0.09);
        }
        .dashboard-insights {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.2em;
            margin-bottom: 2em;
        }
        .insight-card {
            background: var(--card-bg);
