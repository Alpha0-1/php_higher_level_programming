<?php
/**
 * Laravel Installation Example
 * 
 * This script demonstrates how to install Laravel using Composer.
 * It also shows basic environment setup.
 */

// 1. First ensure you have Composer installed globally
// Run this command in your terminal to check:
// $ composer --version

// 2. Install Laravel globally via Composer
// $ composer global require laravel/installer

// 3. Create a new Laravel project
// $ laravel new project-name
// OR using Composer directly:
// $ composer create-project --prefer-dist laravel/laravel project-name

// 4. Serve the application locally
// $ cd project-name
// $ php artisan serve

// The application will be available at http://localhost:8000

echo "Laravel installation instructions. Run the above commands in your terminal.\n";

// Basic environment configuration example
echo "\nAfter installation, configure your .env file with database credentials:\n";
echo "DB_CONNECTION=mysql\n";
echo "DB_HOST=127.0.0.1\n";
echo "DB_PORT=3306\n";
echo "DB_DATABASE=laravel\n";
echo "DB_USERNAME=root\n";
echo "DB_PASSWORD=\n";
?>
