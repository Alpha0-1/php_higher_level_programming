<?php
/**
 * 6-multi_languages_loop.php - Looping Through Languages
 * 
 * This script demonstrates how to use arrays and loops to display
 * multiple language greetings efficiently.
 * 
 * Learning objectives:
 * - Array creation and usage
 * - foreach loop structure
 * - Associative arrays
 * - Loop control structures
 * 
 * Usage: php 6-multi_languages_loop.php
 */

// Indexed array of greetings
$greetings = [
    "Hello, World",
    "Hola, Mundo", 
    "Bonjour, Monde",
    "Hallo, Welt",
    "Ciao, Mondo",
    "Konnichiwa, Sekai",
    "Privet, Mir"
];

echo "Greetings from around the world:\n";
echo "================================\n";

// Method 1: foreach with indexed array
foreach ($greetings as $index => $greeting) {
    echo ($index + 1) . ". $greeting\n";
}

echo "\n";

// Method 2: Associative array with language names
$languageGreetings = [
    "English" => "Hello, World",
    "Spanish" => "Hola, Mundo",
    "French" => "Bonjour, Monde", 
    "German" => "Hallo, Welt",
    "Italian" => "Ciao, Mondo",
    "Japanese" => "Konnichiwa, Sekai",
    "Russian" => "Privet, Mir"
];

echo "Greetings with languages:\n";
echo "========================\n";

foreach ($languageGreetings as $language => $greeting) {
    echo "$language: $greeting\n";
}

// Method 3: Traditional for loop
echo "\nUsing traditional for loop:\n";
echo "===========================\n";

for ($i = 0; $i < count($greetings); $i++) {
    echo "Position $i: " . $greetings[$i] . "\n";
}
?>
