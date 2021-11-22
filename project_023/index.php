<?php
// Mini-blog: posts stored as files in posts/
$postsDir = __DIR__ . '/posts';
if (!is_dir($postsDir)) mkdir($postsDir);
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';
if ($action === 'delete' && $id && file_exists("$postsDir/$id.txt")) {
    unlink("$postsDir/$id.txt");
    header('Location: index.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    if ($title && $body) {
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $title);
        file_put_contents("$postsDir/$filename.txt", $body);
    }
    header('Location: index.php'); exit;
}
