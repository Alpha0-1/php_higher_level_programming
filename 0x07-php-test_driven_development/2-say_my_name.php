<?php
/**
 * Prints a name message.
 *
 * @param string $first First name.
 * @param string $last Last name.
 * @return void
 * @throws InvalidArgumentException If names are not strings.
 */
function say_my_name(string $first, string $last): void {
    if (!is_string($first) || !is_string($last)) {
        throw new InvalidArgumentException("First and last names must be strings");
    }

    echo "My name is $first $last\n";
}

// Example usage:
// say_my_name("John", "Doe"); // Output: My name is John Doe
?>
