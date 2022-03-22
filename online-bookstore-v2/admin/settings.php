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
