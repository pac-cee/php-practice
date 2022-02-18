<?php
// Minimal plain PHP homepage
require_once __DIR__ . '/../Database.php';
$db = new Database();
$conn = $db->getConnection();

$result = $conn->query("SELECT * FROM books");
?>
<!DOCTYPE html>
<html>
<head>
    <title>BookVerse - Book Catalog</title>
</head>
<body>
    <h1>Book Catalog</h1>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <a href="book.php?id=<?php echo $row['id']; ?>">
