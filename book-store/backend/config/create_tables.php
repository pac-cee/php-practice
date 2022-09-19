<?php
// This file creates all necessary database tables if they don't exist

// Books table
$stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS `categories` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(50) NOT NULL,
        `slug` VARCHAR(50) NOT NULL UNIQUE,
        `description` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
$stmt->execute();

// Books table
$stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS `books` (
