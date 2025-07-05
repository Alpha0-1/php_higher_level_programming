<?php
/**
 * Symfony Services Example
 * 
 * Demonstrates dependency injection and service container usage.
 */

namespace App\Service;

class EmailService
{
    private $mailer;
    
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function send(string $to, string $subject, string $body): bool
    {
        $message = (new \Swift_Message($subject))
            ->setFrom('noreply@example.com')
            ->setTo($to)
            ->setBody($body);
            
        return $this->mailer->send($message) > 0;
    }
}

// Service configuration in config/services.yaml:
/*
services:
    App\Service\:
        resource: '../src/Service'
*/

// Controller usage example:
/*
public function index(EmailService $emailService)
{
    $emailService->send('user@example.com', 'Hello', 'Welcome!');
    // ...
}
*/

echo "Service examples. Key features:\n";
echo "- Automatic dependency injection\n";
echo "- Service container manages object creation\n";
echo "- Services are typically stateless\n";
echo "- Can be autowired or manually configured\n";
?>
