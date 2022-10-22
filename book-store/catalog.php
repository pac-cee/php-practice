<?php
  session_start();
  require_once './backend/config/database.php';
  require_once './backend/functions/book_functions.php';
  
  // Get query parameters
  $category = isset($_GET['category']) ? $_GET['category'] : '';
  $search = isset($_GET['search']) ? $_GET['search'] : '';
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $perPage = 12;
  
  // Get books based on filters
  $books = getFilteredBooks($conn, $category, $search, $page, $perPage);
  $totalBooks = getTotalFilteredBooks($conn, $category, $search);
  $totalPages = ceil($totalBooks / $perPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
