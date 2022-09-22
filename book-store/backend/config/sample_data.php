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
        ],
        [
            'title' => 'Pride and Prejudice',
            'author' => 'Jane Austen',
            'description' => 'A romantic novel following the character development of Elizabeth Bennet, who learns about the repercussions of hasty judgments.',
            'price' => 9.99,
            'original_price' => 12.99,
            'cover_image' => 'https://images.pexels.com/photos/1130980/pexels-photo-1130980.jpeg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 1, // Fiction
            'isbn' => '9780141439518',
            'publisher' => 'Penguin Classics',
            'publication_date' => '1813-01-28',
            'pages' => 432,
            'language' => 'English',
            'stock_quantity' => 32,
            'featured' => true
        ],
        [
            'title' => 'The Hobbit',
            'author' => 'J.R.R. Tolkien',
            'description' => 'A fantasy novel about the adventures of hobbit Bilbo Baggins, who is hired as a "burglar" by a group of dwarves seeking to reclaim their treasure from a dragon.',
            'price' => 14.99,
            'original_price' => 17.99,
            'cover_image' => 'https://images.pexels.com/photos/1563075/pexels-photo-1563075.jpeg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 4, // Science Fiction
            'isbn' => '9780547928227',
            'publisher' => 'Houghton Mifflin Harcourt',
            'publication_date' => '1937-09-21',
            'pages' => 304,
            'language' => 'English',
            'stock_quantity' => 28,
            'featured' => true
        ],
        [
            'title' => 'The Da Vinci Code',
            'author' => 'Dan Brown',
            'description' => 'A mystery thriller novel following symbologist Robert Langdon as he investigates a murder in the Louvre Museum.',
            'price' => 11.99,
            'original_price' => 14.99,
            'cover_image' => 'https://images.pexels.com/photos/46792/the-ball-stadion-football-the-pitch-46792.jpeg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 3, // Mystery
            'isbn' => '9780307474278',
            'publisher' => 'Anchor',
            'publication_date' => '2003-03-18',
            'pages' => 597,
            'language' => 'English',
            'stock_quantity' => 42,
            'featured' => false
        ],
        [
            'title' => 'Steve Jobs',
            'author' => 'Walter Isaacson',
            'description' => 'The exclusive biography of Steve Jobs, based on more than forty interviews with Jobs conducted over two years.',
            'price' => 19.99,
            'original_price' => 24.99,
            'cover_image' => 'https://images.pexels.com/photos/256262/pexels-photo-256262.jpeg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 5, // Biography
            'isbn' => '9781451648539',
            'publisher' => 'Simon & Schuster',
            'publication_date' => '2011-10-24',
            'pages' => 656,
            'language' => 'English',
            'stock_quantity' => 15,
            'featured' => false
        ],
        [
            'title' => 'Sapiens: A Brief History of Humankind',
            'author' => 'Yuval Noah Harari',
            'description' => 'A book that explores the history of the human species, from the evolution of archaic human species to the present.',
            'price' => 16.99,
            'original_price' => 19.99,
            'cover_image' => 'https://images.pexels.com/photos/4666751/pexels-photo-4666751.jpeg?auto=compress&cs=tinysrgb&w=1600',
            'category_id' => 2, // Non-Fiction
            'isbn' => '9780062316097',
            'publisher' => 'Harper',
            'publication_date' => '2015-02-10',
