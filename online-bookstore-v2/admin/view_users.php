<?php
// File: admin/view_users.php

require_once __DIR__ . '/../includes/functions_admin.php';
redirectIfNotAdmin();

$message = '';
$error   = '';

// 1) Handle “Create Admin” form submission
if (isset($_POST['create_admin'])) {
    $username    = trim($_POST['username']);
    $email       = trim($_POST['email']);
    $password    = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPass)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirmPass) {
