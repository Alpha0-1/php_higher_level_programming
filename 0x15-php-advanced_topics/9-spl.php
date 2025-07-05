<?php
/**
 * Demonstrates Standard PHP Library (SPL) components
 */

// SplFixedArray - faster alternative for large arrays
$array = new SplFixedArray(5);
$array[0] = 'a';
$array[1] = 'b';
$array[2] = 'c';
$array[3] = 'd';
$array[4] = 'e';

echo "SplFixedArray:\n";
foreach ($array as $item) {
    echo $item . " ";
}
echo "\n";

// SplDoublyLinkedList (base for SplStack and SplQueue)
$list = new SplDoublyLinkedList();
$list->push('first');
$list->push('second');
$list->push('third');

echo "\nDoubly Linked List (FIFO):\n";
$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
foreach ($list as $item) {
    echo $item . " ";
}

echo "\n\nDoubly Linked List (LIFO):\n";
$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
foreach ($list as $item) {
    echo $item . " ";
}
echo "\n";

// SplStack
$stack = new SplStack();
$stack->push('stack item 1');
$stack->push('stack item 2');
$stack->push('stack item 3');

echo "\nStack (LIFO):\n";
foreach ($stack as $item) {
    echo $item . "\n";
}

// SplQueue
$queue = new SplQueue();
$queue->enqueue('queue item 1');
$queue->enqueue('queue item 2');
$queue->enqueue('queue item 3');

echo "\nQueue (FIFO):\n";
foreach ($queue as $item) {
    echo $item . "\n";
}

// SplHeap (abstract - needs implementation)
class NumberHeap extends SplHeap
{
    protected function compare($value1, $value2): int
    {
        return $value1 <=> $value2; // Max-heap (for min-heap, swap $value1 and $value2)
    }
}

$heap = new NumberHeap();
$heap->insert(5);
$heap->insert(3);
$heap->insert(8);
$heap->insert(1);

echo "\nHeap:\n";
foreach ($heap as $number) {
    echo $number . " ";
}
echo "\n";

// SplObjectStorage
$storage = new SplObjectStorage();

$obj1 = new stdClass();
$obj2 = new stdClass();
$obj3 = new stdClass();

$storage->attach($obj1, 'Data for obj1');
$storage->attach($obj2, 'Data for obj2');
$storage->attach($obj3, 'Data for obj3');

echo "\nObject Storage:\n";
foreach ($storage as $object) {
    echo $storage->getInfo() . "\n";
}

// SplFileInfo and SplFileObject
echo "\nFile Operations:\n";
$fileInfo = new SplFileInfo(__FILE__);
echo "File size: " . $fileInfo->getSize() . " bytes\n";
echo "Last modified: " . date('Y-m-d H:i:s', $fileInfo->getMTime()) . "\n";

$file = new SplFileObject(__FILE__);
echo "\nFirst 3 lines of this file:\n";
foreach (new LimitIterator($file, 0, 3) as $line) {
    echo $line;
}

// DirectoryIterator
echo "\n\nDirectory Listing:\n";
foreach (new DirectoryIterator(__DIR__) as $fileInfo) {
    if ($fileInfo->isDot()) continue;
    echo $fileInfo->getFilename() . " (" . ($fileInfo->isDir() ? 'DIR' : 'FILE') . ")\n";
}

// MultipleIterator
echo "\nMultiple Iterator:\n";
$names = new ArrayIterator(['Alice', 'Bob', 'Charlie']);
$ages = new ArrayIterator([25, 30, 35]);

$multi = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
$multi->attachIterator($names, 'name');
$multi->attachIterator($ages, 'age');

foreach ($multi as $person) {
    print_r($person);
}
