<?php
// File: admin/generate_report.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

/**
 * We support three types of reports:
 *  - books: list all books or by category
 *  - sales: all orders between date_from & date_to
 *  - users: user activity (total orders, spent) between date range
 */

$type       = $_GET['type'] ?? '';
$dateFrom   = $_GET['date_from'] ?? '';
$dateTo     = $_GET['date_to'] ?? '';
$categoryId = $_GET['category_id'] ?? '';
$userId     = $_GET['user_id'] ?? '';

