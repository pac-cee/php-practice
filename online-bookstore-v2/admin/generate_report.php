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

if ($type === 'books') {
    // Books Report
    $columns = ['ID','Title','Author','Category','Price ($)','Stock Qty'];
    $sql = "
      SELECT b.id, b.title, b.author, c.name AS category, b.price, b.stock_quantity
      FROM books b
      LEFT JOIN categories c ON b.category_id = c.id
    ";
    if (!empty($categoryId)) {
        $cid = intval($categoryId);
        $sql .= " WHERE b.category_id = $cid";
        $suffix = "_cat_$cid";
    } else {
        $suffix = "_all";
    }
    $sql .= " ORDER BY b.title ASC";
    $res = $conn->query($sql);

    $rows = [];
