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
    
    foreach ($categories as $category) {
        $stmt->bindParam(':name', $category['name']);
        $stmt->bindParam(':slug', $category['slug']);
        $stmt->bindParam(':description', $category['description']);
        $stmt->execute();
    }
    
    // Insert sample books
    $books = [
        [
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'description' => 'Set in the American South during the 1930s, the novel tells the story of a lawyer who defends a Black man falsely accused of rape, as seen through the eyes of the lawyer\'s young daughter.',
            'price' => 12.99,
            'original_price' => 15.99,
            'cover_image' => 'https://images.pexels.com/photos/5834/nature-grass-leaf-green.jpg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 1, // Fiction
            'isbn' => '9780061120084',
            'publisher' => 'Harper Perennial Modern Classics',
            'publication_date' => '1960-07-11',
            'pages' => 336,
            'language' => 'English',
            'stock_quantity' => 25,
            'featured' => true
        ],
        [
            'title' => '1984',
            'author' => 'George Orwell',
            'description' => 'A dystopian novel set in a totalitarian society ruled by the Party, which has total control over every aspect of people\'s lives.',
            'price' => 10.99,
            'original_price' => 14.99,
            'cover_image' => 'https://images.pexels.com/photos/590493/pexels-photo-590493.jpeg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 4, // Science Fiction
            'isbn' => '9780451524935',
            'publisher' => 'Signet Classic',
            'publication_date' => '1949-06-08',
            'pages' => 328,
            'language' => 'English',
            'stock_quantity' => 18,
            'featured' => true
        ],
        [
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'description' => 'Set in the Jazz Age, the novel tells the tragic story of Jay Gatsby and his pursuit of Daisy Buchanan.',
            'price' => 11.99,
            'original_price' => 13.99,
            'cover_image' => 'https://images.pexels.com/photos/46274/pexels-photo-46274.jpeg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 1, // Fiction
            'isbn' => '9780743273565',
            'publisher' => 'Scribner',
            'publication_date' => '1925-04-10',
            'pages' => 180,
            'language' => 'English',
            'stock_quantity' => 0,
            'featured' => false
