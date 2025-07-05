<?php
/**
 * Demonstrates Generators and Iterators in PHP
 */

/**
 * Basic Generator Example
 */
function xrange(int $start, int $end, int $step = 1): Generator
{
    for ($i = $start; $i <= $end; $i += $step) {
        yield $i;
    }
}

// Usage
foreach (xrange(1, 10) as $number) {
    echo "$number ";
}
echo "\n";

/**
 * Memory-efficient file reading with generators
 */
function readLargeFile(string $filename): Generator
{
    $file = fopen($filename, 'r');
    
    if (!$file) {
        throw new RuntimeException("Could not open file $filename");
    }
    
    while (!feof($file)) {
        yield fgets($file);
    }
    
    fclose($file);
}

// Usage (would need a large file to demonstrate properly)
// foreach (readLargeFile('large_file.txt') as $line) {
//     // Process each line without loading entire file into memory
//     echo $line;
// }

/**
 * Sending values to generator
 */
function logger(): Generator
{
    while (true) {
        $message = yield;
        echo date('[Y-m-d H:i:s]') . " $message\n";
    }
}

// Usage
$log = logger();
$log->send('System started');
$log->send('User logged in');
$log->send('Processing data');

/**
 * Custom Iterator implementation
 */
class FibonacciSequence implements Iterator
{
    private int $position = 0;
    private int $current = 1;
    private int $previous = 0;

    public function current(): mixed
    {
        return $this->current;
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        $new = $this->previous + $this->current;
        $this->previous = $this->current;
        $this->current = $new;
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
        $this->current = 1;
        $this->previous = 0;
    }

    public function valid(): bool
    {
        return $this->position < 20; // Limit to first 20 numbers
    }
}

// Usage
$fib = new FibonacciSequence();
foreach ($fib as $index => $value) {
    echo "Fibonacci number #$index is $value\n";
}
