<?php
// File: admin/add_book.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

$message = '';
$error   = '';

// Handle Add or Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title            = trim($_POST['title']);
    $author           = trim($_POST['author']);
    $price            = floatval($_POST['price']);
    $original_price   = floatval($_POST['original_price']);
    $description      = trim($_POST['description']);
    $cover_image      = trim($_POST['cover_image']); // assume URL or path
    $category_id      = intval($_POST['category_id']);
    $isbn             = trim($_POST['isbn']);
