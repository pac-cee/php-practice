<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';

$db = new Database();
$conn = $db->getConnection();
$sql = 'SELECT * FROM quizzes';
$result = $conn->query($sql);
$quizzes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quizzes[] = $row;
    }
}
$conn->close();
