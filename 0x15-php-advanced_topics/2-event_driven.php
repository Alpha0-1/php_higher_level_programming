<?php
/**
 * Demonstrates Event-Driven Programming in PHP
 */

// Basic event system
class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(string $eventName, $eventData = null): void
    {
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener($eventData);
            }
        }
    }
}

// Usage
$dispatcher = new EventDispatcher();

// Add listeners
$dispatcher->addListener('user.registered', function($user) {
    echo "Sending welcome email to: {$user['email']}\n";
});

$dispatcher->addListener('user.registered', function($user) {
    echo "Creating user profile for: {$user['username']}\n";
});

// Trigger event
$user = ['username' => 'john_doe', 'email' => 'john@example.com'];
$dispatcher->dispatch('user.registered', $user);

/**
 * Using Symfony EventDispatcher component (example)
 * 
 * Note: Requires symfony/event-dispatcher package
 * 
 * composer require symfony/event-dispatcher
 */
// 
// use Symfony\Component\EventDispatcher\EventDispatcher;
// use Symfony\Component\EventDispatcher\Event;
// 
// class UserRegisteredEvent extends Event
// {
//     public const NAME = 'user.registered';
// 
//     private $user;
// 
//     public function __construct(array $user)
//     {
//         $this->user = $user;
//     }
// 
//     public function getUser(): array
//     {
//         return $this->user;
//     }
// }
// 
// $dispatcher = new EventDispatcher();
// 
// $dispatcher->addListener(UserRegisteredEvent::NAME, function(UserRegisteredEvent $event) {
//     $user = $event->getUser();
//     echo "[Symfony] Welcome {$user['username']}!\n";
// });
// 
// $event = new UserRegisteredEvent($user);
// $dispatcher->dispatch($event, UserRegisteredEvent::NAME);
