<?php
/**
 * Calculates the weighted average of an array of scores.
 *
 * @param array $scores Associative array of scores
 * @param array $weights Corresponding weights
 * @return float Weighted average
 */
function weighted_average($scores, $weights) {
    if (count($scores) !== count($weights)) {
        echo "Scores and weights must be of equal length.\n";
        return 0;
    }

    $sumScoreWeight = 0;
    $sumWeights = 0;

    foreach ($scores as $key => $score) {
        if (isset($weights[$key])) {
            $sumScoreWeight += $score * $weights[$key];
            $sumWeights += $weights[$key];
        }
    }

    return $sumScoreWeight / $sumWeights;
}

// Example usage
$scores = ['Math' => 90, 'English' => 80, 'Science' => 70];
$weights = ['Math' => 3, 'English' => 2, 'Science' => 1];

echo "Weighted Average: " . weighted_average($scores, $weights) . "\n";
?>
