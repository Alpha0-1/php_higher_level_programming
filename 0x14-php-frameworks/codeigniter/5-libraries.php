<?php
/**
 * CodeIgniter Libraries Example
 * 
 * Demonstrates using and creating libraries.
 */

// Using built-in libraries:
/*
$email = \Config\Services::email();

$email->setFrom('noreply@example.com');
$email->setTo('user@example.com');
$email->setSubject('Test Email');
$email->setMessage('Hello from CodeIgniter!');
$email->send();
*/

// Session library:
/*
$session = \Config\Services::session();
$session->set('user_id', 123);
$userId = $session->get('user_id');
*/

// Creating custom libraries:
// Create app/Libraries/MyLibrary.php
/*
namespace App\Libraries;

class MyLibrary
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
    
    public function doSomething()
    {
        return 'Something was done';
    }
}
*/

// Using the custom library:
/*
$myLib = new \App\Libraries\MyLibrary();
echo $myLib->doSomething();
*/

// Or register as a service in app/Config/Services.php:
/*
public static function mylib($getShared = true)
{
    if ($getShared) {
        return static::getSharedInstance('mylib');
    }
    
    return new \App\Libraries\MyLibrary();
}
*/

// Then use via service locator:
/*
$myLib = \Config\Services::mylib();
*/

echo "Library examples. Key features:\n";
echo "- Many built-in libraries for common tasks\n";
echo "- Service locator pattern for easy access\n";
echo "- Dependency injection support\n";
echo "- Can extend core functionality\n";
?>
