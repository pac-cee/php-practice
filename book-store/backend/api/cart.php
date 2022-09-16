<?php
session_start();
require_once '../config/database.php';
require_once '../functions/cart_functions.php';
require_once '../functions/book_functions.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Set default response
$response = [
    'success' => false,
    'message' => 'Invalid request',
    'cartCount' => 0
];

// Process cart actions
