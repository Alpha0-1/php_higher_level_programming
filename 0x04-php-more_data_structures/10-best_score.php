<?php
/**
 * Finds the highest score in an associative array.
 *
 * @param array $scores Associative array of scores
 * @return mixed Highest score
 */
function find_best_score($scores) {
    if (!is_array($scores) || empty($scores)) {
        echo "Invalid input.\n";
        return null;
    }

    return max($scores);
}

// Example usage
$scores = ['Alice' => 90, 'Bob' => 85, 'Charlie' => 95];
echo "Best score: " . find_best_score($scores) . "\n";
?>
