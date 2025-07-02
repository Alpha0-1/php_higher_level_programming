<?php
/**
 * Prints text with two newlines after each '.', '?', ':'.
 *
 * @param string $text Input text.
 * @return void
 * @throws InvalidArgumentException If input is not a string.
 */
function text_indentation(string $text): void {
    if (!is_string($text)) {
        throw new InvalidArgumentException("Input must be a string");
    }

    $separators = ['.', '?', ':'];
    $lines = explode("\n", wordwrap($text, 70));

    foreach ($lines as $line) {
        $words = explode(' ', $line);
        $outputLine = '';
        foreach ($words as $word) {
            $outputLine .= $word . ' ';
            if (in_array(substr(trim($word), -1), $separators)) {
                $outputLine = trim($outputLine);
                echo $outputLine . "\n\n";
                $outputLine = '';
            }
        }

        if (!empty($outputLine)) {
            echo trim($outputLine) . "\n";
        }
    }
}

// Example usage:
// text_indentation("Hello. World? How are you: I'm fine.");
?>
