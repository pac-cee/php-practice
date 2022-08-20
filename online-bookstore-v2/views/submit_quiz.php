<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['quiz_id']) || !isset($_POST['answers'])) {
    echo '<p>Invalid quiz submission.</p><a href="quiz.php">&larr; Back to Quizzes</a>';
    exit;
}
$user_id = $_SESSION['user_id'];
$quiz_id = intval($_POST['quiz_id']);
$answers = $_POST['answers'];
$db = new Database();
$conn = $db->getConnection();
// Fetch correct answers
$sql = 'SELECT id, correct_answer FROM quiz_questions WHERE quiz_id = ?';
