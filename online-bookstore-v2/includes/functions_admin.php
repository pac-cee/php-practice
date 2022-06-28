<?php
// File: includes/functions_admin.php

// 1) Load the DB connection class
require_once __DIR__ . '/../config/db.php';
// 2) Place FPDF if you generate PDF reports here.
//    (We'll leave that require for generatePDF itself.)

session_start();

// 3) Instantiate Database & expose $conn globally
$db   = new Database();
$conn = $db->getConnection();

/**
 * redirectIfNotAdmin()
 * --------------------
 * Verifies that $_SESSION['role'] === 'admin'. If not, redirect to admin_login.php.
 */
