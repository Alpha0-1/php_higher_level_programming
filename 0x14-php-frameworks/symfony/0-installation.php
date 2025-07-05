<?php
/**
 * Symfony Installation Example
 * 
 * Demonstrates how to install Symfony and create a new project.
 */

// 1. Install Symfony CLI (recommended)
// Download from https://symfony.com/download or:
/*
$ wget https://get.symfony.com/cli/installer -O - | bash
$ export PATH="$HOME/.symfony/bin:$PATH"
*/

// 2. Create a new Symfony project
/*
$ symfony new my_project --full (full web app)
$ symfony new my_project (microservice/skeleton)
*/

// 3. Start the local web server
/*
$ cd my_project
$ symfony server:start
*/

// 4. Install dependencies (if using composer)
/*
$ composer require webapp
*/

echo "Symfony installation instructions. The Symfony CLI provides:\n";
echo "- Local web server with HTTPS support\n";
echo "- Debugging tools\n";
echo "- Integration with Symfony Cloud\n\n";

echo "Alternative installation via Composer:\n";
echo "$ composer create-project symfony/website-skeleton my_project\n";
?>
