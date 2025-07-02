<?php
/**
 * Magic String Generator
 * Returns a unique string each time it's called without repeating.
 */

class MagicString {
    private static $counter = 0;
    private static $usedStrings = [];

    public function get() {
        do {
            $str = uniqid("magic_", true);
        } while (in_array($str, self::$usedStrings));

        self::$usedStrings[] = $str;
        return $str;
    }
}

// Usage
$ms = new MagicString();
echo $ms->get() . "\n";
echo $ms->get() . "\n"; // Will always be different
?>
