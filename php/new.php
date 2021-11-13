<?php
// Variables and data types
$name = "John";               // String
$age = 25;                    // Integer
$height = 1.75;               // Float
$isStudent = true;            // Boolean
$hobbies = ["reading", "coding", "music"]; // Array

// Echo and print statements
echo "Hello, " . $name . "!\n";
print("You are $age years old\n");

// If-else condition
if ($age >= 18) {
    echo "You are an adult\n";
} else {
    echo "You are a minor\n";
}

// Loops
// For loop
for ($i = 0; $i < 3; $i++) {
    echo "Counter: $i\n";
}

// While loop
$counter = 0;
while ($counter < 3) {
    echo "While counter: $counter\n";
    $counter++;
}

// Functions
function greet($person) {
    return "Hello, $person!";
}

echo greet($name);

// Associative array
$person = [
    "name" => "John",
    "age" => 25,
    "city" => "New York"
];

// Accessing associative array
echo "\nPerson details:\n";
foreach ($person as $key => $value) {
    echo "$key: $value\n";
}


// ...existing code...

// User Input Handling
echo "\nPlease enter your name: ";
