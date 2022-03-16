<?php
// File: admin/register_admin.php

require_once __DIR__ . '/../config/db.php';
session_start();

// Check if user is already logged in as admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Already logged in as admin, redirect to dashboard
    header('Location: dashboard.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$message = '';
$messageType = '';

// Get schools for dropdown (if needed)
$schools = [];
$schoolsQuery = $conn->query("SELECT id, name FROM schools ORDER BY name");
if ($schoolsQuery) {
    while ($row = $schoolsQuery->fetch_assoc()) {
        $schools[$row['id']] = $row['name'];
    }
}

// Get memberships for dropdown (if needed)
$memberships = [];
$membershipsQuery = $conn->query("SELECT id, name FROM memberships ORDER BY name");
if ($membershipsQuery) {
    while ($row = $membershipsQuery->fetch_assoc()) {
        $memberships[$row['id']] = $row['name'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
