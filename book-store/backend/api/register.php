<?php
session_start();
require_once '../config/database.php';

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $terms = isset($_POST['terms']) ? (bool)$_POST['terms'] : false;
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';
    
    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        header("Location: ../../register.php?error=empty" . ($redirect ? "&redirect=$redirect" : ''));
        exit;
    }
    
    if ($password !== $confirmPassword) {
        header("Location: ../../register.php?error=password" . ($redirect ? "&redirect=$redirect" : ''));
        exit;
    }
    
    if (!$terms) {
        header("Location: ../../register.php?error=terms" . ($redirect ? "&redirect=$redirect" : ''));
        exit;
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("
