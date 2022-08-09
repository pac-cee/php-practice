<?php
// File: views/profile.php

// 1) Include the Database class and create a $conn instance
require_once __DIR__ . '/../config/db.php';
session_start();

$dbInstance = new Database();
$conn       = $dbInstance->getConnection();

// 2) Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$uid     = $_SESSION['user_id'];
$error   = '';
$message = '';

// 3) Fetch user information (name, username, email, password hash)
$stmtUser = $conn->prepare("SELECT name, username, email, password FROM users WHERE id = ? LIMIT 1");
$stmtUser->bind_param('i', $uid);
$stmtUser->execute();
$resUser = $stmtUser->get_result();

if ($resUser->num_rows !== 1) {
    // Something’s wrong—user not found => force logout
    header('Location: logout.php');
    exit;
}

$user = $resUser->fetch_assoc();

// 4) Handle Password Update
if (isset($_POST['update_password'])) {
    $currentPassword    = $_POST['current_password'] ?? '';
    $newPassword        = $_POST['new_password'] ?? '';
    $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $error = 'All password fields are required.';
    } elseif (!password_verify($currentPassword, $user['password'])) {
        $error = 'Current password is incorrect.';
    } elseif (strlen($newPassword) < 6) {
        $error = 'New password must be at least 6 characters long.';
    } elseif ($newPassword !== $confirmNewPassword) {
        $error = 'New password and confirmation do not match.';
    } else {
        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmtUpd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmtUpd->bind_param('si', $newHash, $uid);
        if ($stmtUpd->execute()) {
            $message         = 'Password updated successfully.';
            $user['password'] = $newHash;
        } else {
            $error = 'Error updating password. Please try again later.';
