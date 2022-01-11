<?php
// JWT Refresh Tokens
// Requires: composer require firebase/php-jwt
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
$key = 'secret';
$refreshFile = 'refresh_tokens.json';
$refreshTokens = file_exists($refreshFile) ? json_decode(file_get_contents($refreshFile), true) : [];
$action = $_POST['action'] ?? '';
if ($action === 'login') {
    $user = 'user1';
    $payload = ['sub'=>$user, 'exp'=>time()+60];
    $jwt = JWT::encode($payload, $key, 'HS256');
    $refresh = bin2hex(random_bytes(16));
    $refreshTokens[$refresh] = $user;
    file_put_contents($refreshFile, json_encode($refreshTokens));
    echo json_encode(['jwt'=>$jwt, 'refresh'=>$refresh]);
} elseif ($action === 'refresh' && isset($_POST['refresh'])) {
    $refresh = $_POST['refresh'];
