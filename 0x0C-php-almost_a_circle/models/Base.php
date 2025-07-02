<?php
/**
 * Base class for geometric shapes.
 */
abstract class Base {
    /**
     * @var int Unique identifier for each instance.
     */
    private $id;

    /**
     * Static counter to assign unique IDs.
     *
     * @var int
     */
    private static $counter = 1;

    /**
     * Constructor initializes the ID with an auto-incremented value.
     */
    public function __construct() {
        $this->id = self::$counter++;
    }

    /**
     * Get the ID of the shape.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Abstract method to be implemented by subclasses.
     *
     * @return mixed
     */
    abstract public function area();
}
?>
