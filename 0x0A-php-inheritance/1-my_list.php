<?php
/**
 * Class MyList - Extends built-in array functionality.
 */
class MyList extends ArrayObject {
    /**
     * Adds multiple items to the list.
     * @param array $items Items to add.
     */
    public function addMultiple(array $items) {
        foreach ($items as $item) {
            $this[] = $item;
        }
    }

    /**
     * Prints all elements in the list.
     */
    public function printList() {
        foreach ($this as $item) {
            echo $item . "\n";
        }
    }
}

// Example usage:
$list = new MyList();
$list->addMultiple(['Apple', 'Banana', 'Cherry']);
$list->printList();
?>
