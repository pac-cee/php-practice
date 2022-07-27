<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';
$username = $_SESSION['username'] ?? 'User';
$role = $_SESSION['role'] ?? 'individual';
$user_id = $_SESSION['user_id'];

// Fetch stats for insights
$db = new Database();
$conn = $db->getConnection();
$books = $conn->query('SELECT COUNT(*) AS c FROM books');
$book_count = $books ? $books->fetch_assoc()['c'] : 0;
$quizzes = $conn->query('SELECT COUNT(*) AS c FROM quizzes');
$quiz_count = $quizzes ? $quizzes->fetch_assoc()['c'] : 0;
$orders = $conn->query('SELECT COUNT(*) AS c FROM orders WHERE user_id = ' . intval($user_id));
