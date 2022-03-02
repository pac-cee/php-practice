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
