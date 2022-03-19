<?php
// File: admin/register_admin.php

require_once __DIR__ . '/../config/db.php';
session_start();

// Check if user is already logged in as admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Already logged in as admin, redirect to dashboard
    header('Location: dashboard.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$message = '';
$messageType = '';

// Get schools for dropdown (if needed)
$schools = [];
$schoolsQuery = $conn->query("SELECT id, name FROM schools ORDER BY name");
if ($schoolsQuery) {
    while ($row = $schoolsQuery->fetch_assoc()) {
        $schools[$row['id']] = $row['name'];
    }
}

// Get memberships for dropdown (if needed)
$memberships = [];
$membershipsQuery = $conn->query("SELECT id, name FROM memberships ORDER BY name");
if ($membershipsQuery) {
    while ($row = $membershipsQuery->fetch_assoc()) {
        $memberships[$row['id']] = $row['name'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $schoolId = !empty($_POST['school_id']) ? (int)$_POST['school_id'] : null;
    $membershipId = !empty($_POST['membership_id']) ? (int)$_POST['membership_id'] : null;
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($username)) {
        $errors[] = "Username is required";
    } else {
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Username already exists";
        }
        $stmt->close();
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email already exists";
        }
        $stmt->close();
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    
    // If no errors, insert the new admin user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'admin'; // Always set role to admin for this page
        
        $stmt = $conn->prepare("
            INSERT INTO users (name, username, email, password, role, school_id, membership_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param('sssssii', $name, $username, $email, $hashedPassword, $role, $schoolId, $membershipId);
        
        if ($stmt->execute()) {
            $messageType = 'success';
            $message = "Admin account created successfully! Redirecting to login page...";
            // Set a redirect with JavaScript after displaying the message
            header("refresh:3;url=admin_login.php");
        } else {
            $messageType = 'error';
            $message = "Error creating account: " . $conn->error;
