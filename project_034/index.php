<?php
session_start();
$db = new PDO('sqlite:users.db');
$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT, password TEXT)");
$msg = '';
if (isset($_POST['register'])) {
    $u = $_POST['user']; $p = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $db->prepare('INSERT INTO users (username, password) VALUES (?,?)')->execute([$u,$p]);
    $msg = 'Registered!';
}
if (isset($_POST['login'])) {
    $u = $_POST['user']; $p = $_POST['pass'];
    $row = $db->prepare('SELECT * FROM users WHERE username=?')->execute([$u])->fetchArray(SQLITE3_ASSOC);
    $row = $db->query('SELECT * FROM users WHERE username = "'.$u.'"')->fetch(PDO::FETCH_ASSOC);
    if ($row && password_verify($p, $row['password'])) {
        $_SESSION['user'] = $u; $msg = 'Logged in!';
    } else {
        $msg = 'Login failed!';
    }
