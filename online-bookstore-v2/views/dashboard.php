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
$order_count = $orders ? $orders->fetch_assoc()['c'] : 0;
$last_score = $conn->query('SELECT score, total FROM quiz_results WHERE user_id = ' . intval($user_id) . ' ORDER BY taken_at DESC LIMIT 1');
$score_row = $last_score ? $last_score->fetch_assoc() : null;
// --- Dynamic Activity Feed ---
$activity = [];
$conn = $db->getConnection();
// Last 3 orders
$stmt = $conn->prepare('SELECT b.title, o.order_date FROM orders o JOIN books b ON o.book_id = b.id WHERE o.user_id = ? ORDER BY o.order_date DESC LIMIT 3');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$order_result = $stmt->get_result();
while ($row = $order_result->fetch_assoc()) {
    $activity[] = [
        'type' => 'order',
        'title' => $row['title'],
        'date' => $row['order_date']
    ];
}
$stmt->close();
// Last 3 quiz attempts
$stmt = $conn->prepare('SELECT q.title, qr.taken_at, qr.score, qr.total FROM quiz_results qr JOIN quizzes q ON qr.quiz_id = q.id WHERE qr.user_id = ? ORDER BY qr.taken_at DESC LIMIT 3');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$quiz_result = $stmt->get_result();
while ($row = $quiz_result->fetch_assoc()) {
    $activity[] = [
        'type' => 'quiz',
        'title' => $row['title'],
        'date' => $row['taken_at'],
        'score' => $row['score'],
        'total' => $row['total']
    ];
}
$stmt->close();
// Sort activity by date desc
usort($activity, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
$activity = array_slice($activity, 0, 5);
// --- Dynamic Recommendations ---
$recommend_books = [];
$recommend_quiz = null;
// Books user hasn't ordered
$stmt = $conn->prepare('SELECT b.id, b.title, b.author FROM books b WHERE b.id NOT IN (SELECT o.book_id FROM orders o WHERE o.user_id = ?) LIMIT 2');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$rec_books_result = $stmt->get_result();
while ($row = $rec_books_result->fetch_assoc()) {
    $recommend_books[] = $row;
}
$stmt->close();
// Quiz user hasn't taken
$stmt = $conn->prepare('SELECT q.id, q.title FROM quizzes q WHERE q.id NOT IN (SELECT qr.quiz_id FROM quiz_results qr WHERE qr.user_id = ?) LIMIT 1');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$rec_quiz_result = $stmt->get_result();
if ($row = $rec_quiz_result->fetch_assoc()) {
