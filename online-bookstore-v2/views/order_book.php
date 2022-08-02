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
