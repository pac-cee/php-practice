<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';

$user_id = $_SESSION['user_id'];
$db = new Database();
$conn = $db->getConnection();
$sql = 'SELECT o.id, b.title, b.author, b.price, o.order_date, o.status FROM orders o JOIN books b ON o.book_id = b.id WHERE o.user_id = ? ORDER BY o.order_date DESC';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
