<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $db   = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare('
            SELECT id, password, role 
            FROM users 
            WHERE username = ? 
            LIMIT 1
        ');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash, $role);
            $stmt->fetch();

            if (password_verify($password, $hash)) {
                $_SESSION['user_id']  = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role']     = $role;

                // Redirect based on role
                if ($role === 'admin') {
                    header('Location: ../admin/dashboard.php');
                } else {
                    header('Location: dashboard.php');
                }
                exit;
            } else {
                $message = 'Incorrect password.';
            }
        } else {
            $message = 'User not found.';
        }
        $stmt->close();
        $conn->close();
    } else {
        $message = 'Please fill all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
