<?php
// File: admin/admin_login.php

require_once __DIR__ . '/../config/db.php';
session_start();

// If user is already logged in as admin, redirect to dashboard
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: dashboard.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$error = '';
$debug = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both email and password.';
    } else {
        // Prepare & execute lookup
        $stmt = $conn->prepare("
            SELECT id, username, password, role
            FROM users
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
        if ($stmt->num_rows === 1) {
