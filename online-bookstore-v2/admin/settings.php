<?php
// File: admin/settings.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

$message = '';
$error   = '';

// Ensure you have a `settings` table. If not, run:
/*
  CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value VARCHAR(255) NOT NULL
  );
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stockThreshold = intval($_POST['stock_threshold']);
    $salesTax       = floatval($_POST['sales_tax']);
    $emailVerify    = isset($_POST['email_verify']) ? '1' : '0';

    // Helper to insert/update
    $pairs = [
      ['stock_threshold', $stockThreshold],
      ['sales_tax', $salesTax],
      ['email_verify', $emailVerify]
    ];
    foreach ($pairs as $pair) {
        $key = $pair[0];
        $val = (string)$pair[1];
        $stmt = $conn->prepare("
          INSERT INTO settings (setting_key, setting_value)
          VALUES (?, ?)
          ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
        ");
        $stmt->bind_param('ss', $key, $val);
