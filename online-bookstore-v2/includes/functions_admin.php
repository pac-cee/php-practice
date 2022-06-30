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
function redirectIfNotAdmin() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: /admin/admin_login.php');
        exit;
    }
}

/**
 * hashPassword($plainPassword): string
 * ------------------------------------
 * Hash a plain‐text password using bcrypt.
 */
function hashPassword($plainPassword) {
    return password_hash($plainPassword, PASSWORD_BCRYPT);
}

/**
 * verifyPassword($plainPassword, $hash): bool
 * -------------------------------------------
 * Verify a plain‐text password against its bcrypt hash.
 */
function verifyPassword($plainPassword, $hash) {
    return password_verify($plainPassword, $hash);
}

/**
 * getStats(): array
 * -----------------
 * Returns an associative array of admin KPIs:
 *  - total_books
 *  - total_users
 *  - total_orders
 *  - total_revenue
 */
function getStats() {
    // pull in our global connection
    global $conn;
    $stats = [];
