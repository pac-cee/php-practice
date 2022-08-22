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
$qstmt->execute();
$qres = $qstmt->get_result();
$quiz = $qres->fetch_assoc();
if (!$quiz) {
    echo '<p>Quiz not found.</p><a href="quiz.php">&larr; Back to Quizzes</a>';
    exit;
}
// Fetch quiz questions
$sql = 'SELECT * FROM quiz_questions WHERE quiz_id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
$stmt->close();
$conn->close();
