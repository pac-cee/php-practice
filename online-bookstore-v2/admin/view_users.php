<?php
// File: admin/view_users.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

$message = '';
$error   = '';

// 1) Handle “Create Admin” form submission
if (isset($_POST['create_admin'])) {
    $username    = trim($_POST['username']);
    $email       = trim($_POST['email']);
    $password    = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPass)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirmPass) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email or username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Username or email already in use.';
        } else {
            $hash = hashPassword($password);
            $stmt2 = $conn->prepare("
              INSERT INTO users (name, username, password, email, role)
              VALUES (?, ?, ?, ?, 'admin')
            ");
            // We'll set name = username for simplicity
            $stmt2->bind_param('ssss', $username, $username, $hash, $email);
            if ($stmt2->execute()) {
                $message = 'New admin account created.';
