<?php
/**
 * Demonstrates advanced namespace usage in PHP
 */

// Basic namespace declaration
namespace MyApp\Database;

class Connection
{
    public function connect(): string
    {
        return "Connected to database";
    }
}

function logMessage(string $message): void
{
    echo "Database log: $message\n";
}

const TIMEOUT = 30;

// Using multiple namespaces in one file
namespace MyApp\Http;

class Request
{
    public function handle(): string
    {
        return "Handling HTTP request";
    }
}

// Global namespace
namespace {
    // Using classes from different namespaces
    $dbConnection = new MyApp\Database\Connection();
    $httpRequest = new MyApp\Http\Request();

    echo $dbConnection->connect() . "\n";
    echo $httpRequest->handle() . "\n";

    // Using functions and constants from namespaces
    MyApp\Database\logMessage("Application started");
    echo "Timeout: " . \MyApp\Database\TIMEOUT . " seconds\n";

    // Aliasing with 'use'
    use MyApp\Database\Connection as DBConnection;
    use function MyApp\Database\logMessage as dbLog;
    use const MyApp\Database\TIMEOUT as DB_TIMEOUT;

    $db = new DBConnection();
    dbLog("Using aliases");
    echo "Aliased timeout: " . DB_TIMEOUT . "\n";

    // Group use declarations (PHP 7.0+)
    use MyApp\Database\{
        Connection as Conn,
        function logMessage as dbLogMessage,
        const TIMEOUT as DB_TIMEOUT_CONST
    };
}

// Namespace with sub-namespaces
namespace MyApp\Services\Payment;

class Processor
{
    public function process(float $amount): string
    {
        return "Processing payment of $amount";
    }
}

// Autoloading with namespaces (simulated)
namespace {
    spl_autoload_register(function ($className) {
        // Convert namespace separators to directory separators
        $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
        
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    });

    // This would trigger the autoloader in a real application
    // $paymentProcessor = new \MyApp\Services\Payment\Processor();
}
