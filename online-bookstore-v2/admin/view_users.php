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
            } else {
                $error = 'Error creating admin: ' . $conn->error;
            }
        }
    }
}

// 2) Handle Promote / Demote via GET param ?toggle_role=USER_ID
if (isset($_GET['toggle_role'])) {
    $uid = intval($_GET['toggle_role']);
    // Fetch current role
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $newRole = ($row['role'] === 'admin') ? 'individual' : 'admin';
        $stmt2 = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt2->bind_param('si', $newRole, $uid);
        $stmt2->execute();
    }
    header('Location: view_users.php');
    exit;
}

// 3) Handle Delete user via GET param ?delete_id=USER_ID
if (isset($_GET['delete_id'])) {
    $did = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $did);
    $stmt->execute();
    header('Location: view_users.php');
    exit;
}

// 4) Fetch all users (with optional search)
$search = '';
