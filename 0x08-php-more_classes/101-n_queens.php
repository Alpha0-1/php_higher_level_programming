<?php
/**
 * Solve N-Queens problem using backtracking.
 */
class NQueens {
    private $solutions = [];

    public function solveNQueens($n) {
        $board = array_fill(0, $n, array_fill(0, $n, '.'));
        $this->backtrack($board, 0, $n);
        return $this->solutions;
    }

    private function backtrack(&$board, $row, $n) {
        if ($row === $n) {
            $solution = [];
            foreach ($board as $r) {
                $solution[] = implode('', $r);
            }
            $this->solutions[] = $solution;
            return;
        }

        for ($col = 0; $col < $n; $col++) {
            if ($this->isSafe($board, $row, $col, $n)) {
                $board[$row][$col] = 'Q';
                $this->backtrack($board, $row + 1, $n);
                $board[$row][$col] = '.';
            }
        }
    }

    private function isSafe($board, $row, $col, $n) {
        // Check column
        for ($i = 0; $i < $row; $i++) {
            if ($board[$i][$col] === 'Q') return false;
        }

        // Check upper left diagonal
        for ($i = $row - 1, $j = $col - 1; $i >= 0 && $j >= 0; $i--, $j--) {
            if ($board[$i][$j] === 'Q') return false;
        }

        // Check upper right diagonal
        for ($i = $row - 1, $j = $col + 1; $i >= 0 && $j < $n; $i--, $j++) {
            if ($board[$i][$j] === 'Q') return false;
        }

        return true;
    }
}

// Example usage:
$nq = new NQueens();
$solutions = $nq->solveNQueens(4);

foreach ($solutions as $index => $solution) {
    echo "Solution " . ($index + 1) . ":\n";
    foreach ($solution as $line) {
        echo $line . "\n";
    }
    echo "\n";
}
?>
