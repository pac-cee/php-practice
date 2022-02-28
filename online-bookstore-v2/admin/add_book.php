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
    $publisher        = trim($_POST['publisher']);
    $publication_date = trim($_POST['publication_date']);
    $pages            = intval($_POST['pages']);
    $language         = trim($_POST['language']);
    $stock_quantity   = intval($_POST['stock_quantity']);
    $featured         = isset($_POST['featured']) ? 1 : 0;

    // If edit_id present → update; else → insert
    if (!empty($_POST['edit_id'])) {
        // UPDATE flow
        $edit_id = intval($_POST['edit_id']);
        $stmt = $conn->prepare("
            UPDATE books
            SET title = ?, author = ?, price = ?, original_price = ?, description = ?, cover_image = ?,
                category_id = ?, isbn = ?, publisher = ?, publication_date = ?, pages = ?, language = ?,
                stock_quantity = ?, featured = ?
            WHERE id = ?
        ");
        $stmt->bind_param(
            'ssddssisssiiiii',
            $title,
            $author,
            $price,
            $original_price,
            $description,
            $cover_image,
            $category_id,
            $isbn,
            $publisher,
            $publication_date,
            $pages,
            $language,
            $stock_quantity,
            $featured,
            $edit_id
        );
        if ($stmt->execute()) {
            $message = 'Book updated successfully.';
