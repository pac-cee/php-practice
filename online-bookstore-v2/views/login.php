<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $db   = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare('
            SELECT id, password, role 
            FROM users 
            WHERE username = ? 
            LIMIT 1
        ');
