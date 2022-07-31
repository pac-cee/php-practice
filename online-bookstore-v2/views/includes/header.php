<?php
// Calculate the relative path to the root directory based on the current file path
$currentPath = $_SERVER['SCRIPT_NAME'];
$rootPath = '../';

// Handle nested includes
if (strpos($currentPath, '/views/includes/') !== false) {
    $rootPath = '../../';
}

// Page title fallback
$pageTitle = $pageTitle ?? 'Online Bookstore';

// Common meta tags and basic CSS
$commonHead = <<<HTML
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A modern online bookstore to buy, sell, and manage books.">
    <link rel="icon" type="image/png" href="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/72x72/1f4da.png">
