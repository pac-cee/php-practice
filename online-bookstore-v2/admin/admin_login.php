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
            // Bind the columns
            $stmt->bind_result($id, $username, $hash, $role);
            $stmt->fetch();

            // Check role & password
            if ($role === 'admin' && password_verify($password, $hash)) {
                // Login successful
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                
                // Redirect to dashboard
                header('Location: dashboard.php');
                exit;
            } else {
                // Login failed - provide appropriate error
                if ($role !== 'admin') {
                    $error = 'This account does not have admin privileges.';
                } else {
                    $error = 'Invalid password.';
                }
            }
        } else {
            $error = 'No account found with that email.';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login • OnlineBookstore</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* Centered login box */
