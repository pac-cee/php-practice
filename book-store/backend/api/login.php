<?php
session_start();
require_once '../config/database.php';

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? (bool)$_POST['remember'] : false;
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';
    
    // Validate form data
    if (empty($email) || empty($password)) {
        header("Location: ../../login.php?error=empty" . ($redirect ? "&redirect=$redirect" : ''));
        exit;
    }
    
    // Check if user exists
    $stmt = $conn->prepare("
        SELECT id, name, email, password, is_admin
        FROM users
        WHERE email = :email
    ");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch();
    
    if (!$user || !password_verify($password, $user['password'])) {
        header("Location: ../../login.php?error=invalid" . ($redirect ? "&redirect=$redirect" : ''));
        exit;
