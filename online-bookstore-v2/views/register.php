<?php
require_once __DIR__ . '/../config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    if ($username && $email && $password && $password === $confirm) {
        $db = new Database();
        $conn = $db->getConnection();
        // Check if username exists
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = 'Username already exists.';
        } else {
            // Check if email exists
            $stmt->close();
            $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $message = 'Email already registered.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->close();
                $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
                $stmt->bind_param('sss', $username, $email, $hash);
                if ($stmt->execute()) {
                    $message = 'Registration successful! <a href="login.php">Login here</a>.';
                } else {
                    $message = 'Registration failed. Please try again.';
                }
            }
        }
        $stmt->close();
        $conn->close();
    } else {
        $message = 'Please fill all fields and ensure passwords match.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - OnlineBookstore</title>
    <link rel="icon" type="image/png" href="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/72x72/1f4da.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
