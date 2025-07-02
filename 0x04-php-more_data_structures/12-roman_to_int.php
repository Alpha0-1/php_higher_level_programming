<?php
/**
 * Converts a Roman numeral to an integer.
 *
 * @param string $roman Roman numeral string
 * @return int Converted integer
 */
function roman_to_int($roman) {
    $map = [
        'I' => 1,
        'V' => 5,
        'X' => 10,
        'L' => 50,
        'C' => 100,
        'D' => 500,
        'M' => 1000,
    ];

    $total = 0;
    $prevValue = 0;

    $roman = strtoupper($roman);
    $length = strlen($roman);

    for ($i = $length - 1; $i >= 0; $i--) {
        $value = $map[$roman[$i]] ?? 0;
        if ($value < $prevValue) {
            $total -= $value;
        } else {
            $total += $value;
        }
        $prevValue = $value;
    }

    return $total;
}

// Example usage
echo "Roman to Int: " . roman_to_int("MCMXCIV") . "\n"; // Should output 1994
?>
