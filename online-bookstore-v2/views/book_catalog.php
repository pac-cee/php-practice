<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';

$db = new Database();
$conn = $db->getConnection();
$sql = 'SELECT b.*, a.audio_file FROM books b LEFT JOIN audio_books a ON b.id = a.book_id';
$result = $conn->query($sql);
$books = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
$conn->close();
