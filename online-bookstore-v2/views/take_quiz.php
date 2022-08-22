<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';

if (!isset($_GET['quiz_id'])) {
    echo '<p>Quiz not specified.</p><a href="quiz.php">&larr; Back to Quizzes</a>';
    exit;
}
$quiz_id = intval($_GET['quiz_id']);
$db = new Database();
$conn = $db->getConnection();
// Fetch quiz info
$qsql = 'SELECT * FROM quizzes WHERE id = ?';
$qstmt = $conn->prepare($qsql);
$qstmt->bind_param('i', $quiz_id);
