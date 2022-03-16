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

