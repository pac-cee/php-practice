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
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `author` VARCHAR(100) NOT NULL,
        `description` TEXT,
        `price` DECIMAL(10,2) NOT NULL,
        `original_price` DECIMAL(10,2),
        `cover_image` VARCHAR(255) NOT NULL,
        `category_id` INT,
        `isbn` VARCHAR(20) NOT NULL UNIQUE,
        `publisher` VARCHAR(100),
        `publication_date` DATE,
        `pages` INT,
        `language` VARCHAR(50),
        `stock_quantity` INT NOT NULL DEFAULT 0,
        `featured` BOOLEAN DEFAULT FALSE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
$stmt->execute();

// Users table
$stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `is_admin` BOOLEAN DEFAULT FALSE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
$stmt->execute();

// Addresses table
$stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS `addresses` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `name` VARCHAR(100) NOT NULL,
        `street_address` VARCHAR(255) NOT NULL,
        `city` VARCHAR(100) NOT NULL,
        `state` VARCHAR(100) NOT NULL,
        `zip_code` VARCHAR(20) NOT NULL,
        `country` VARCHAR(100) NOT NULL,
        `phone` VARCHAR(20) NOT NULL,
        `is_default` BOOLEAN DEFAULT FALSE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
$stmt->execute();

// Payment methods table
$stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS `payment_methods` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `card_type` VARCHAR(50) NOT NULL,
        `last_four` VARCHAR(4) NOT NULL,
        `expiry_month` VARCHAR(2) NOT NULL,
        `expiry_year` VARCHAR(4) NOT NULL,
        `is_default` BOOLEAN DEFAULT FALSE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
$stmt->execute();

// Orders table
$stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS `orders` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
        `total_amount` DECIMAL(10,2) NOT NULL,
        `shipping_address_id` INT NOT NULL,
        `payment_method_id` INT NOT NULL,
        `shipping_method` VARCHAR(50) NOT NULL,
        `shipping_cost` DECIMAL(10,2) NOT NULL,
        `tax_amount` DECIMAL(10,2) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses`(`id`),
        FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
$stmt->execute();

// Order items table
