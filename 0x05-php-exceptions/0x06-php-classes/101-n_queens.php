<?php
/**
 * NQueensSolver - Solves the N-Queens problem using backtracking.
 */
class NQueensSolver {
    private $solutions = [];

    /**
     * Solve the N-Queens problem.
     *
     * @param int $n Size of the board.
     * @return array All valid solutions.
     */
    public function solve($n) {
        $this->backtrack([], 0, $n);
        return $this->solutions;
    }

    /**
     * Backtracking helper function.
     *
     * @param array $queens Current queen positions.
     * @param int   $row    Current row being processed.
     * @param int   $n      Board size.
     */
    private function backtrack($queens, $row, $n) {
        if ($row === $n) {
            $this->solutions[] = $queens;
            return;
        }

        for ($col = 0; $col < $n; $col++) {
            if ($this->isSafe($queens, $row, $col)) {
                $this->backtrack(array_merge($queens, [$col]), $row + 1, $n);
            }
        }
    }

    /**
     * Checks if placing a queen at ($row, $col) is safe.
     *
     * @param array $queens Queen positions so far.
     * @param int   $row    Row to place.
     * @param int   $col    Column to check.
     * @return bool True if safe.
     */
    private function isSafe($queens, $row, $col) {
        foreach ($queens as $r => $c) {
            if ($c === $col || abs($c - $col) === $row - $r) {
                return false;
            }
        }
        return true;
    }

    /**
     * Prints all found solutions.
     */
    public function printSolutions() {
        foreach ($this->solutions as $solution) {
            foreach ($solution as $pos) {
                echo str_pad('', $pos, '.') . 'Q' . str_pad('', count($solution) - $pos - 1, '.') . "\n";
            }
            echo "\n";
        }
    }
}

// Example usage:
$solver = new NQueensSolver();
$solutions = $solver->solve(4);
echo "Found " . count($solutions) . " solutions for N=4:\n\n";
$solver->printSolutions();
?>
