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
