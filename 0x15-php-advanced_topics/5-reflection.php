<?php
/**
 * Demonstrates PHP's Reflection API
 */

class UserController
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): string
    {
        return 'User list';
    }

    protected function show(int $id): string
    {
        return "User details for ID: $id";
    }

    private function secretMethod(): string
    {
        return 'This is private';
    }
}

class UserRepository {}

// Basic class reflection
$reflectionClass = new ReflectionClass('UserController');

// Get class information
echo "Class name: " . $reflectionClass->getName() . "\n";
echo "Is abstract? " . ($reflectionClass->isAbstract() ? 'Yes' : 'No') . "\n";

// Get methods
echo "\nMethods:\n";
foreach ($reflectionClass->getMethods() as $method) {
    echo "- " . $method->getName() . 
         " (visibility: " . implode(' ', Reflection::getModifierNames($method->getModifiers())) . ")\n";
}

// Get constructor parameters
echo "\nConstructor parameters:\n";
$constructor = $reflectionClass->getConstructor();
foreach ($constructor->getParameters() as $param) {
    echo "- " . $param->getName() . " (type: " . $param->getType() . ")\n";
}

// Inspecting a method
echo "\nInspecting 'show' method:\n";
$method = $reflectionClass->getMethod('show');
echo "Return type: " . $method->getReturnType() . "\n";
echo "Parameters:\n";
foreach ($method->getParameters() as $param) {
    echo "- " . $param->getName() . " (type: " . $param->getType() . ")\n";
}

// Dynamic instantiation with dependencies
echo "\nCreating instance dynamically:\n";
$constructor = $reflectionClass->getConstructor();
$parameters = [];
foreach ($constructor->getParameters() as $param) {
    $paramClass = $param->getType()->getName();
    $parameters[] = new $paramClass();
}

$instance = $reflectionClass->newInstanceArgs($parameters);
var_dump($instance);

// Calling protected method
echo "\nCalling protected method:\n";
$method = $reflectionClass->getMethod('show');
$method->setAccessible(true);
echo $method->invoke($instance, 42) . "\n";

// Property manipulation
echo "\nProperty manipulation:\n";
$property = $reflectionClass->getProperty('repository');
$property->setAccessible(true);
echo "Current repository: " . get_class($property->getValue($instance)) . "\n";
$property->setValue($instance, new stdClass());
echo "New repository: " . get_class($property->getValue($instance)) . "\n";
