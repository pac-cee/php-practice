<?php
// Check if there are any categories
$stmt = $conn->prepare("SELECT COUNT(*) FROM categories");
$stmt->execute();
$categoryCount = $stmt->fetchColumn();

// Only insert sample data if there are no categories
if ($categoryCount === 0) {
    // Insert sample categories
    $categories = [
        ['name' => 'Fiction', 'slug' => 'fiction', 'description' => 'Novels, short stories, and other fictional works'],
        ['name' => 'Non-Fiction', 'slug' => 'non-fiction', 'description' => 'Biographies, memoirs, self-help, and educational books'],
        ['name' => 'Mystery', 'slug' => 'mystery', 'description' => 'Suspense, detective, and crime novels'],
        ['name' => 'Science Fiction', 'slug' => 'science-fiction', 'description' => 'Science fiction, fantasy, and speculative fiction'],
        ['name' => 'Biography', 'slug' => 'biography', 'description' => 'Biographies and autobiographies of notable individuals'],
        ['name' => 'History', 'slug' => 'history', 'description' => 'Books about historical events, periods, and figures']
    ];
    
    $stmt = $conn->prepare("INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description)");
